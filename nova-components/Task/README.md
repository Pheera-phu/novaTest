# Task Management Nova Tool Documentation

## ภาพรวม (Overview)
Task Tool เป็น Laravel Nova Tool ที่พัฒนาขึ้นเพื่อจัดการงาน (Task Management) โดยสามารถแสดงสถิติและรายละเอียดของงานต่างๆ ผ่านหน้าเว็บที่สวยงามและใช้งานง่าย

## โครงสร้างไฟล์และการทำงาน

### 1. โครงสร้างหลัก (Main Structure)

```
nova-components/Task/
├── src/                     # ไฟล์ PHP หลัก
├── resources/              # Frontend assets
├── routes/                 # Route definitions
├── dist/                   # Built assets
├── composer.json          # PHP dependencies
├── package.json           # JavaScript dependencies
└── webpack.mix.js         # Build configuration
```

### 2. ไฟล์ PHP Backend

#### 2.1 `composer.json`
- **หน้าที่**: กำหนดข้อมูลแพคเกจ, dependencies, และ autoload
- **สำคัญ**: 
  - Namespace: `Acme\Task`
  - Service Provider: `Acme\Task\ToolServiceProvider`
  - ต้องการ Laravel Nova ^5.0

#### 2.2 `src/ToolServiceProvider.php`
- **หน้าที่**: Service Provider หลักที่ลงทะเบียน Tool กับ Laravel Nova
- **การทำงาน**:
  ```php
  // 1. ลงทะเบียน routes
  protected function routes(): void
  {
      // Route สำหรับ Inertia (หน้าเว็บ)
      Nova::router(['nova', 'nova.auth', Authorize::class], 'task')
          ->group(__DIR__.'/../routes/inertia.php');
      
      // Route สำหรับ API
      Route::middleware(['nova', 'nova.auth', Authorize::class])
          ->prefix('nova-vendor/task')
          ->group(__DIR__.'/../routes/api.php');
  }
  
  // 2. โหลด frontend assets
  Nova::serving(function (ServingNova $event) {
      Nova::mix('Task', __DIR__.'/../dist/mix-manifest.json');
  });
  ```

#### 2.3 `src/Task.php`
- **หน้าที่**: คลาสหลักของ Tool ที่สืบทอดมาจาก `Laravel\Nova\Tool`
- **การทำงาน**:
  ```php
  // สร้างเมนูใน Nova sidebar
  public function menu(Request $request): MenuSection
  {
      return MenuSection::make('Task')
          ->path('/task')          // URL path
          ->icon('folder');        // ไอคอน
  }
  
  // โหลด assets
  public function boot(): void
  {
      Nova::mix('task', __DIR__.'/../dist/mix-manifest.json');
  }
  ```

#### 2.4 `src/Http/Middleware/Authorize.php`
- **หน้าที่**: ตรวจสอบสิทธิ์การเข้าถึง Tool
- **การทำงาน**:
  - ตรวจสอบว่า Tool ถูกลงทะเบียนใน Nova
  - ตรวจสอบสิทธิ์ผู้ใช้ผ่าน `authorize()` method
  - Return 404 หรือ 403 หากไม่มีสิทธิ์

### 3. Routes

#### 3.1 `routes/inertia.php`
- **หน้าที่**: กำหนด route สำหรับหน้าเว็บ (Inertia.js)
- **การทำงาน**:
  ```php
  Route::get('/', function (NovaRequest $request) {
      return inertia('Task');  // โหลดหน้า Task.vue
  });
  ```

#### 3.2 `routes/api.php`
- **หน้าที่**: กำหนด API routes สำหรับดึงข้อมูล
- **การทำงาน**:
  ```php
  Route::get('/tasks', function (Request $request) {
      // คำนวณสถิติ
      $totalTasks = task::count();
      $pendingTasks = task::where('status', 'รอดำเนินการ')->count();
      $inProgressTasks = task::where('status', 'กำลังดำเนินการ')->count();
      $completedTasks = task::where('status', 'เสร็จสิ้น')->count();
  
      // ดึงข้อมูลงานทั้งหมด
      $tasks = task::orderBy('created_at', 'desc')->get();
  
      return response()->json([
          'stats' => [...],
          'tasks' => $tasks
      ]);
  });
  ```

### 4. Frontend Assets

#### 4.1 `resources/js/tool.js`
- **หน้าที่**: Entry point ของ JavaScript
- **การทำงาน**:
  ```javascript
  import Tool from './pages/Tool'
  
  // ลงทะเบียน component กับ Nova
  Nova.inertia('Task', Tool)
  
  // Boot callback
  Nova.booting((app, store) => {
      // Custom logic เมื่อ Nova boot
  })
  ```

#### 4.2 `resources/js/pages/Tool.vue`
- **หน้าที่**: หน้าหลักของ Tool (ไฟล์ที่คุณแนบมา)
- **ฟีเจอร์หลัก**:
  - แสดงสถิติงาน (รวม, รอดำเนินการ, กำลังดำเนินการ, เสร็จสิ้น)
  - แสดงรายการงานแบบ Card
  - สามารถขยาย/ยุบรายละเอียดงาน
  - รองรับภาษาไทย
  - Responsive design

### 5. Build Configuration

#### 5.1 `webpack.mix.js`
- **หน้าที่**: กำหนดการ build frontend assets
- **การทำงาน**:
  ```javascript
  mix
    .setPublicPath('dist')           // Output directory
    .js('resources/js/tool.js', 'js') // Compile JS
    .vue({ version: 3 })             // Vue 3 support
    .css('resources/css/tool.css', 'css') // Compile CSS
    .nova('acme/task')               // Nova tool integration
    .version()                       // Asset versioning
  ```

#### 5.2 `package.json`
- **หน้าที่**: กำหนด npm scripts และ dependencies
- **Scripts สำคัญ**:
  - `npm run dev`: Build สำหรับ development
  - `npm run watch`: Build และ watch สำหรับการเปลี่ยนแปลง
  - `npm run production`: Build สำหรับ production

## ขั้นตอนการทำงาน (Workflow)

### 1. การลงทะเบียน Tool
1. `ToolServiceProvider` ถูกโหลดโดย Laravel
2. `boot()` method ลงทะเบียน routes และ assets
3. `Task` class สร้างเมนูใน Nova sidebar

### 2. การเข้าถึงหน้า Tool
1. ผู้ใช้คลิกเมนู "Task" ใน Nova
2. Request ไปที่ `/nova/tools/task`
3. `Authorize` middleware ตรวจสอบสิทธิ์
4. `inertia.php` route return หน้า `Task` component

### 3. การโหลดข้อมูล
1. `Tool.vue` component ถูก mount
2. `fetchTasks()` method เรียก API `/nova-vendor/task/tasks`
3. `api.php` route ดึงข้อมูลจาก database
4. ส่งข้อมูลกลับในรูปแบบ JSON

### 4. การแสดงผล
1. Vue component รับข้อมูล JSON
2. แสดงสถิติในส่วนบน
3. แสดงรายการงานแบบ Card
4. ผู้ใช้สามารถขยาย/ยุบรายละเอียดได้

## การติดตั้งและใช้งาน

### 1. การติดตั้ง
```bash
# ติดตั้ง dependencies
composer install
npm install

# Build assets
npm run production
```

### 2. การลงทะเบียนใน NovaServiceProvider
```php
// app/Providers/NovaServiceProvider.php
public function tools(): array
{
    return [
        new \Acme\Task\Task,
    ];
}
```

### 3. การกำหนด Model
Tool นี้ใช้ `App\Models\task` model ซึ่งต้องมีฟิลด์:
- `status` (รอดำเนินการ, กำลังดำเนินการ, เสร็จสิ้น)
- `issue`, `task`, `project`, `types`, `author`
- `start_date`, `end_date`
- `remark`, `tester`, `testRound`

## สรุป

Nova Tool นี้ประกอบด้วย:
- **Backend**: PHP classes ที่จัดการ routing, authorization, และ API
- **Frontend**: Vue.js component ที่แสดงผลข้อมูล
- **Build System**: Laravel Mix ที่ compile assets
- **Integration**: การเชื่อมต่อกับ Laravel Nova framework

การทำงานเป็นไปตาม MVC pattern โดย:
- **Model**: `App\Models\task`
- **View**: `Tool.vue` component
- **Controller**: API routes ใน `api.php`

Tool นี้เป็นตัวอย่างที่ดีของการสร้าง Nova Tool ที่มีทั้ง backend API และ frontend interface ที่สมบูรณ์
