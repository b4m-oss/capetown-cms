<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

trait LockableTrait
{
    protected $lockDuration; // ロックの有効時間
    protected $lockColumn; // ロックカラム名
    protected $lockable = false; // ロック機能の有効性フラグ

    /**
     * トレイトの初期化処理。
     * ロックカラム名とロックの有効時間を設定し、ロック機能の検証を行う。
     */
    public function initializeLockableTrait()
    {
        $this->lockDuration = config('app.lock_duration', 60); // デフォルトのロック時間を設定
        $this->lockColumn = env('LOCK_COLUMN', 'locked_at'); // .envからロックカラム名を取得

        // ロック機能の初期検証
        $this->validateLockable();
    }

    /**
     * ロック機能の有効性を検証する。
     * ロックカラムが存在し、型がdatetimeであることを確認する。
     * エラーがあればログに警告を記録する。
     */
    protected function validateLockable()
    {
        if (!Schema::hasColumn($this->getTable(), $this->lockColumn)) {
            $this->lockable = false;
            Log::warning("ロックカラムの名称が違います: {$this->lockColumn}");
            return;
        }

        $columnType = \DB::select("SHOW COLUMNS FROM {$this->getTable()} LIKE '{$this->lockColumn}'");
        if (empty($columnType) || $columnType[0]->Type !== 'datetime') {
            $this->lockable = false;
            Log::warning("ロックカラムの型はdatetimeでなければなりません: {$this->lockColumn}");
            return;
        }

        $this->lockable = true;
    }

    /**
     * モデルをロックする。
     * ロック機能が有効な場合、ロックを設定する。
     */
    public function lock()
    {
        if ($this->isLockable()) {
            // ロックを設定
            $this->{$this->lockColumn} = Carbon::now();
            $this->save();
        }
    }

    /**
     * モデルのロックを解除する。
     * ロック機能が有効な場合、ロックを解除する。
     */
    public function unlock()
    {
        if ($this->isLockable()) {
            // ロックを解除
            $this->{$this->lockColumn} = null;
            $this->save();
        }
    }

    /**
     * モデルがロックされているかどうかを確認する。
     *
     * @return bool ロックされている場合はtrue、そうでない場合はfalse。
     */
    public function isLocked()
    {
        if ($this->isLockable()) {
            // 有効時間が経過していなければロックされている
            return Carbon::now()->diffInSeconds($this->{$this->lockColumn}) < $this->lockDuration;
        }
        return false;
    }

    /**
     * モデルが編集可能かどうかを確認する。
     *
     * @return bool 編集可能な場合はtrue、ロックされている場合はfalse。
     */
    public function canEdit()
    {
        return !$this->isLocked();
    }

    /**
     * ロックの有効時間を設定する。
     *
     * @param int $seconds ロックの有効時間（秒数）。
     */
    public function setLockDuration(int $seconds)
    {
        $this->lockDuration = $seconds;
    }

    /**
     * ロック機能が有効かどうかを確認する。
     *
     * @return bool ロック機能が有効な場合はtrue、無効な場合はfalse。
     */
    public function isLockable(): bool
    {
        return $this->lockable;
    }
}
