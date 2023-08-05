<?php

use App\Http\Controllers\absensi\AbsensiController;
use App\Http\Controllers\agama\AgamaController;
use App\Http\Controllers\auth\CekLoginController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\ekskul\EkskulController;
use App\Http\Controllers\guru\GuruController;
use App\Http\Controllers\interface\wali_murid\WaliMuridInterfaceController;
use App\Http\Controllers\jadwal_mengajar\JadwalMengajarController;
use App\Http\Controllers\jadwal_pelajaran\JadwalPelajaranController;
use App\Http\Controllers\jurusan\JurusanController;
use App\Http\Controllers\kelas\KelasController;
use App\Http\Controllers\mata_pelajaran\MataPelajaranController;
use App\Http\Controllers\murid\MuridController;
use App\Http\Controllers\nilai_akademik\NilaiAkademikController;
use App\Http\Controllers\pengaturan\ProfilSekolahController;
use App\Http\Controllers\pengaturan\ProfilUserController;
use App\Http\Controllers\rapor\RaporController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\wali_murid\WaliMuridController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route("login");
})->name('welcome');

Route::get('/enjoy', function () {
    return Inertia::render('enjoy_page');
})->name('enjoy');

Route::group(["middleware" => ["auth"]], function () {
    Route::group(['prefix' => 'pengaturan', 'as' => 'pengaturan.'], function () {
        Route::resource('profil-sekolah', ProfilSekolahController::class);
        Route::resource('profil-user', ProfilUserController::class);
    });

    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
        Route::resource('nilai-akademik', NilaiAkademikController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::resource('rapor', RaporController::class);
        Route::apiResource('jadwal-mengajar', JadwalMengajarController::class);
    });

    Route::group(['prefix' => 'master', 'as' => 'master.'], function () {
        Route::resource('ekskul', EkskulController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('mata-pelajaran', MataPelajaranController::class);
        Route::resource('murid', MuridController::class);
        Route::resource('user', UserController::class);
        Route::resource('wali-murid', WaliMuridController::class);
        Route::apiResource('agama', AgamaController::class);
        Route::apiResource('jadwal-pelajaran', JadwalPelajaranController::class);
        Route::post('jadwal-mengajar/tugas', [JadwalMengajarController::class,'tugas'])->name("jadwal-pelajaran.tugas");
        Route::post('jadwal-mengajar/hapus-tugas', [JadwalMengajarController::class,'hapus_tugas'])->name("jadwal-pelajaran.hapus_tugas");
        Route::post('jadwal-mengajar/nilai-tugas', [JadwalMengajarController::class,'nilai_tugas'])->name("jadwal-pelajaran.nilai_tugas");
    });

    Route::resource('dashboard', DashboardController::class);
    Route::group(['prefix' => 'interface','as' => 'interface.'],function () {
        Route::apiResource("wali-murid",WaliMuridInterfaceController::class);
    });
});

Route::get("login", LoginController::class)->name("login");
Route::post("cek-login", CekLoginController::class)->name("cek-login");
Route::post("logout", LogoutController::class)->name("logout");
