<?php

use App\Models\Buku;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoStudentAccountSeeder;
use Database\Seeders\InitialAdminSeeder;
use Database\Seeders\InitialStaffAccountsSeeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

test('admin and petugas can log in', function () {
    expect(app()->environment())->toBe('testing')
        ->and(app()->runningInConsole())->toBeTrue()
        ->and(app()->runningUnitTests())->toBeTrue();

    $user = User::factory()->create([
        'email' => 'admin@example.com',
        'role' => 'admin',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

test('demo student account can log in and access linked borrowing history', function () {
    $this->seed(DemoStudentAccountSeeder::class);
    $this->seed(DemoStudentAccountSeeder::class);

    $student = User::where('email', 'siswa@perpustakaan.test')->firstOrFail();

    expect(User::where('email', 'siswa@perpustakaan.test')->count())->toBe(1);

    $this->assertDatabaseHas('anggotas', [
        'nis_nip' => 'S-DEMO-001',
        'email' => 'siswa@perpustakaan.test',
    ]);

    $this->post('/login', [
        'email' => 'siswa@perpustakaan.test',
        'password' => 'password',
    ])->assertRedirect(route('katalog-buku.index'));

    $this->assertAuthenticatedAs($student);
    $this->get('/peminjaman-saya')->assertSuccessful();
});

test('initial admin seeder hashes the configured password', function () {
    Config::set('admin.bootstrap', [
        'name' => 'Initial Admin',
        'email' => 'initial-admin@example.com',
        'password' => 'correct-horse-battery-staple',
    ]);

    $this->seed(InitialAdminSeeder::class);

    $admin = User::where('email', 'initial-admin@example.com')->firstOrFail();

    expect($admin->role)->toBe('admin')
        ->and(Hash::check('correct-horse-battery-staple', $admin->password))->toBeTrue()
        ->and($admin->password)->not->toBe('correct-horse-battery-staple');
});

test('initial admin seeder refuses to create a second admin', function () {
    User::factory()->create(['role' => 'admin']);
    Config::set('admin.bootstrap', [
        'name' => 'Second Admin',
        'email' => 'second-admin@example.com',
        'password' => 'correct-horse-battery-staple',
    ]);

    expect(fn () => $this->seed(InitialAdminSeeder::class))
        ->toThrow(LogicException::class);
});

test('admin password reset command changes the password without exposing it', function () {
    $admin = User::factory()->create([
        'email' => 'reset-admin@example.com',
        'role' => 'admin',
        'password' => 'old-admin-password',
    ]);

    $this->artisan('admin:reset-password', ['email' => $admin->email])
        ->expectsQuestion('New password (minimum 16 characters)', 'a-long-new-admin-password')
        ->expectsQuestion('Confirm new password', 'a-long-new-admin-password')
        ->expectsOutput('Admin password updated.')
        ->assertExitCode(0);

    expect(Hash::check('a-long-new-admin-password', $admin->fresh()->password))->toBeTrue()
        ->and(Hash::check('old-admin-password', $admin->fresh()->password))->toBeFalse();
});

test('demo database seeder refuses to run in production', function () {
    $environment = app()->environment();
    app()->instance('env', 'production');

    try {
        expect(fn () => app(DatabaseSeeder::class)->run())
            ->toThrow(LogicException::class);
    } finally {
        app()->instance('env', $environment);
    }
});

test('petugas cannot manage categories', function () {
    $this->actingAs(User::factory()->create(['role' => 'petugas']))
        ->get('/kategoris')
        ->assertForbidden();
});

test('admin can see dashboard statistics and export book report', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']));
    Buku::create([
        'kode_buku' => 'BK-ADMIN',
        'judul' => 'Buku Administrasi',
        'penulis' => 'Admin',
        'penerbit' => 'Sekolah',
        'stok' => 3,
    ]);

    $this->get('/dashboard')
        ->assertSuccessful()
        ->assertSee('Total judul buku');

    $this->get('/laporan/buku/excel')
        ->assertSuccessful()
        ->assertHeader('content-type', 'application/vnd.ms-excel; charset=UTF-8')
        ->assertSee('Buku Administrasi');
});

test('kepala sekolah can only review borrowing reports', function () {
    $this->actingAs(User::factory()->create(['role' => 'kepala_sekolah']));

    $this->get('/dashboard')
        ->assertSuccessful()
        ->assertSee('Laporan Peminjaman')
        ->assertDontSee('Buku</a>');

    $this->get('/laporan')
        ->assertSuccessful()
        ->assertSee('Laporan Peminjaman')
        ->assertDontSee('Laporan Buku');

    $this->get('/laporan/peminjaman/excel')->assertSuccessful();
    $this->get('/laporan/buku/excel')->assertForbidden();
    $this->get('/bukus')->assertForbidden();
    $this->get('/setting')->assertSuccessful();
    $this->get('/profil')->assertForbidden();

    $this->put('/setting', [
        'library_name' => 'Perpustakaan Utama',
        'address' => 'Jl. Sekolah 1',
        'email' => 'library@example.com',
        'whatsapp' => '+62 8120000000',
        'max_books' => 4,
        'loan_duration_days' => 10,
        'fine_per_day' => 5000,
        'renewal_limit' => 1,
        'email_notifications' => true,
    ])->assertRedirect('/setting');

    expect(DB::table('library_settings')->value('library_name'))->toBe('Perpustakaan Utama');
});

test('staff can access operational pages but cannot access settings', function () {
    $this->actingAs(User::factory()->create(['role' => 'petugas']));

    $this->get('/dashboard')->assertSuccessful();
    $this->get('/bukus')->assertSuccessful();
    $this->get('/peminjamans')->assertSuccessful();
    $this->get('/laporan')->assertSuccessful();
    $this->get('/profil')->assertSuccessful();
    $this->get('/setting')->assertForbidden();
    $this->put('/setting', [])->assertForbidden();
});

test('admin navigation exposes management tools while staff navigation stays scoped', function () {
    $this->actingAs(User::factory()->create(['role' => 'admin']))
        ->get('/bukus')
        ->assertSuccessful()
        ->assertSee(route('anggotas.index'))
        ->assertDontSee(route('kategoris.index'))
        ->assertDontSee(route('raks.index'));

    $this->actingAs(User::factory()->create(['role' => 'petugas']))
        ->get('/bukus')
        ->assertSuccessful()
        ->assertSee(route('anggotas.index'))
        ->assertDontSee(route('kategoris.index'))
        ->assertDontSee(route('setting'));
});

test('initial staff accounts can log in as petugas and kepala sekolah', function () {
    $accounts = [
        [
            'role' => 'petugas',
            'name' => 'Petugas Bootstrap',
            'email' => 'petugas-bootstrap@example.com',
            'password' => 'petugas-bootstrap-password',
        ],
        [
            'role' => 'kepala_sekolah',
            'name' => 'Kepala Bootstrap',
            'email' => 'kepala-bootstrap@example.com',
            'password' => 'kepala-bootstrap-password',
        ],
    ];

    foreach ($accounts as $account) {
        Config::set('admin.staff_bootstrap', $account);
        $this->seed(InitialStaffAccountsSeeder::class);

        $user = User::where('email', $account['email'])->firstOrFail();

        expect($user->role)->toBe($account['role'])
            ->and(Hash::check($account['password'], $user->password))->toBeTrue();

        $this->post('/login', [
            'email' => $account['email'],
            'password' => $account['password'],
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/login');
    }
});

test('initial staff seeder refuses to create duplicate role accounts', function () {
    User::factory()->create(['role' => 'petugas']);
    Config::set('admin.staff_bootstrap', [
        'role' => 'petugas',
        'name' => 'Petugas',
        'email' => 'petugas@example.com',
        'password' => 'petugas-long-password',
    ]);

    expect(fn () => $this->seed(InitialStaffAccountsSeeder::class))
        ->toThrow(LogicException::class);
});
