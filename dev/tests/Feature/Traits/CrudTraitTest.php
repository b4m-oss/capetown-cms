<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{get, post, put, delete};

uses(RefreshDatabase::class);

beforeEach(function () {
    // テーブルが存在する場合は削除
    Schema::dropIfExists('test_models');

    // Create a test model and table
    Schema::create('test_models', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    // Create a test model class
    $this->model = new class extends Model {
        protected $table = 'test_models';
        protected $fillable = ['name'];
    };

    // テスト用のトレイトクラスを作成
    $this->trait = new class($this->model) { // ここでモデルを渡す
        use \App\Traits\CrudTrait;

        private $model; // モデルを格納するプライベートプロパティを追加

        public function __construct($model)
        {
            $this->model = $model; // プライベートプロパティにモデルを代入
            $this->modelClass = get_class($model);
        }

        public function getModel()
        {
            return new $this->modelClass;
        }

        // テスト用のラッパーメソッドを追加
        public function testStore($request)
        {
            return $this->store($request); // 直接storeを呼び出す
        }

        public function testUpdate($request, $id)
        {
            return $this->update($request, $id); // 直接storeを呼び出す
        }
    };
});

describe('Normal Cases', function () {
    it('can index records', function () {
        $this->model::create(['name' => 'Test Record 1']);
        $this->model::create(['name' => 'Test Record 2']);

        $records = $this->trait->index();

        expect($records)->toHaveCount(2);
    });

    it('can show a record', function () {
        $record = $this->model::create(['name' => 'Test Record']);

        $result = $this->trait->show($record->id);

        expect($result->name)->toBe('Test Record');
    });

    it('can create a record', function () {
        $request = new Request(['name' => 'New Name']);

        // ここでバリデーションルールが必要
        // $request->setLaravelSession([]);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $record = $this->trait->testStore($request); // storeメソッドを呼び出す

        \Log::info($record);

        // 期待される型（オブジェクト）でのアサーション
        expect($record)->toBeInstanceOf($this->model); // モデルのクラスに置き換え
        expect($record->name)->toBe('New Name');
    });

    it('can update a record', function () {
        $record = $this->model::create(['name' => 'Old Name']);
        $result = $this->trait->testUpdate(['name' => 'New Name'], $record->id);

        // $updatedRecord = $this->trait->testUpdate($request, $record->id); // Use the wrapper method

        // Debugging: Use expect for better error reporting
        // expect($updatedRecord)->toHaveProperty('name', 'The updated record does not have the expected name property');
        expect($updatedRecord->name)->toBe('New Name', 'The updated record name does not match the expected value');
    });

    it('can delete a record', function () {
        $record = $this->model::create(['name' => 'To be deleted']);

        $result = $this->trait->destroy($record->id);

        expect($result)->toBe(['message' => 'Resource deleted']);
        expect($this->model::find($record->id))->toBeNull();
    });

    it('can bulk delete records', function () {
        $record1 = $this->model::create(['name' => 'Record 1']);
        $record2 = $this->model::create(['name' => 'Record 2']);

        $result = $this->trait->bulkDelete([$record1->id, $record2->id]);

        expect($result)->toBeTrue();
        expect($this->model::find($record1->id))->toBeNull();
        expect($this->model::find($record2->id))->toBeNull();
    });

    it('can bulk update records', function () {
        $record1 = $this->model::create(['name' => 'Old Name 1']);
        $record2 = $this->model::create(['name' => 'Old Name 2']);

        $updates = [
            $record1->id => ['name' => 'New Name 1'],
            $record2->id => ['name' => 'New Name 2'],
        ];

        $result = $this->trait->bulkUpdate($updates);

        expect($result)->toBeTrue();
        expect($this->model::find($record1->id)->name)->toBe('New Name 1');
        expect($this->model::find($record2->id)->name)->toBe('New Name 2');
    });
});

describe('Error Cases', function () {
    it('returns error when showing non-existent record', function () {
        $result = $this->trait->show(999);

        expect($result)->toBe(['message' => 'Resource not found']);
    });
});
