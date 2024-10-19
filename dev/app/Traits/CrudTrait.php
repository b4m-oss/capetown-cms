<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

trait CrudTrait
{
    use LockableTrait; // LockableTraitを使用

    /**
     * 一覧表示
     */
    public function index()
    {
        try {
            $model = $this->getModel();

            // 最大件数を.envから取得
            $maxResults = (int) env('MAX_RESULTS', 0); // デフォルト値を0に設定

            // 最大件数が設定されている場合、制限をかける
            if ($maxResults > 0) {
                $records = $model::limit($maxResults)->get();
            } else {
                $records = $model::all(); // 最大件数が設定されていない場合は全件取得
            }

            return $records; // JSONではなく直接返す
        } catch (\Exception $e) {
            return ['message' => 'Error fetching records', 'error' => $e->getMessage()];
        }
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);

            return $record;
        } catch (ModelNotFoundException $e) {
            return ['message' => 'Resource not found'];
        } catch (\Exception $e) {
            return ['message' => 'Error fetching record', 'error' => $e->getMessage()];
        }
    }

    /**
     * 新規作成フォームの表示
     */
    public function create()
    {
        return ['message' => 'Create form'];
    }

    /**
     * 新規作成
     */
    public function store(Request $request)
    {
        try {
            $model = $this->getModel();
            $record = $model::create($request->validated());

            return $record;
        } catch (\Exception $e) {
            return ['message' => 'Error creating record', 'error' => $e->getMessage()];
        }
    }

    /**
     * 編集フォームの表示
     */
    public function edit($id)
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);

            return $record;
        } catch (ModelNotFoundException $e) {
            return ['message' => 'Resource not found'];
        } catch (\Exception $e) {
            return ['message' => 'Error fetching record', 'error' => $e->getMessage()];
        }
    }

    /**
     * 更新
     */
    public function update(Request $request, $id)
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);

            // ロック状態の確認
            if ($this->isLocked($record)) {
                \Log::info('Record is locked', ['record_id' => $id]);
                return ['message' => 'Resource is locked by another user.'];
            }

            $record->update($request->validated());

            return $record;
        } catch (ModelNotFoundException $e) {
            return ['message' => 'Resource not found'];
        } catch (\Exception $e) {
            return ['message' => 'Error updating record', 'error' => $e->getMessage()];
        }
    }

    /**
     * 削除
     */
    public function destroy($id)
    {
        try {
            $model = $this->getModel();
            $record = $model::findOrFail($id);

            // ロック状態の確認
            if ($this->isLocked($record)) {
                return ['message' => 'Resource is locked by another user.'];
            }

            $record->delete();

            return ['message' => 'Resource deleted'];
        } catch (ModelNotFoundException $e) {
            return ['message' => 'Resource not found'];
        } catch (\Exception $e) {
            return ['message' => 'Error deleting record', 'error' => $e->getMessage()];
        }
    }

    /**
     * モデルの取得
     */
    protected function getModel()
    {
        return app()->make($this->modelClass);
    }

    /**
     * 複数同時削除
     */
    public function bulkDelete(array $ids): bool
    {
        try {
            $deletedCount = $this->getModel()::whereIn('id', $ids)->delete();

            return $deletedCount > 0;
        } catch (\Exception $e) {
            return false; // 失敗時にはfalseを返す
        }
    }

    /**
     * 複数同時更新
     */
    public function bulkUpdate(array $updates): bool
    {
        try {
            foreach ($updates as $id => $data) {
                $this->getModel()::where('id', $id)->update($data);
            }

            return true; // 全ての更新が成功した場合はtrueを返す
        } catch (\Exception $e) {
            return false; // 失敗時にはfalseを返す
        }
    }

    /**
     * ページネーションを行うメソッド
     *
     * @param  int|null  $perPage  ページサイズ（指定しない場合は.envから取得）
     * @param  int|null  $maxResults  最大件数（指定しない場合は.envから取得）
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|array
     *                                                                     ページネーション結果、または全件取得の場合は全レコード
     *                                                                     エラー発生時にはエラーメッセージの配列を返す
     */
    public function paginate(?int $perPage = null, ?int $maxResults = null)
    {
        try {
            // 最大件数を.envから取得
            $maxResults = (int) env('MAX_RESULTS', 0); // デフォルト値を0に設定

            // ページサイズを.envから取得（引数で上書き可能）
            $perPage = $perPage ?? (int) env('PER_PAGE', 10); // デフォルト値を10に設定

            // クエリパラメータで全件出力要求があれば、全件を取得
            if (request()->query('all') === 'true') {
                return $this->getModel()::all(); // 全件返す
            }

            // 最大件数を超えないように調整
            if ($maxResults > 0 && $perPage > $maxResults) {
                $perPage = $maxResults; // 最大件数を超えないように調整
            }

            $results = $this->getModel()::paginate($perPage);

            return $results; // ページネーション結果をそのまま返す
        } catch (\Exception $e) {
            return ['message' => 'Error fetching paginated records', 'error' => $e->getMessage()];
        }
    }

    /**
     * 文字列検索
     *
     * @param  string  $keyword  検索キーワード
     * @param  mixed  $columns  検索対象カラム（カンマ区切り文字列または配列）
     * @return array 検索結果と次のカーソル
     */
    public function search(string $keyword, $columns = ['*'])
    {
        // columnsが文字列の場合はカンマ区切りで配列に変換
        if (is_string($columns)) {
            $columns = explode(',', $columns);
        } elseif (! is_array($columns)) {
            $columns = ['*']; // デフォルトは全カラム
        }

        // 最大件数を.envから取得
        $maxResults = (int) env('MAX_RESULTS', 0); // デフォルト値を0に設定

        try {
            $query = $this->getModel()::where(function ($query) use ($keyword, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%'.$keyword.'%');
                }
            });

            $totalResults = $query->count(); // 総件数を取得

            // 最大件数が設定されている場合のみ制限をかける
            if ($maxResults > 0 && $totalResults > $maxResults) {
                $results = $query->limit($maxResults)->get();
                $nextCursor = $results->last() ? $results->last()->id : null; // 次のカーソルを設定
            } else {
                $results = $query->get(); // 最大件数が設定されていない場合は全件取得
                $nextCursor = null; // 次のカーソルなし
            }

            return [
                'results' => $results,
                'next_cursor' => $nextCursor,
                'total' => $totalResults,
            ];
        } catch (\Exception $e) {
            return ['message' => 'Error searching records', 'error' => $e->getMessage()];
        }
    }
}
