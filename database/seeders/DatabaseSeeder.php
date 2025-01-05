<?php

namespace Database\Seeders;

use App\Enums\StatusType;
use App\Models\Attendance;
use App\Models\Division;
use App\Models\Institution;
use App\Models\Mentor;
use App\Models\Participant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $institutions = [
      [
        'name' => 'Universitas Indonesia',
        'description' => 'Perguruan tinggi terkemuka yang berlokasi di DKI Jakarta.',
        'region' => 'DKI Jakarta',
        'city' => 'Jakarta Selatan'
      ],
      [
        'name' => 'Institut Teknologi Bandung',
        'description' => 'Institut yang terkenal dengan program teknik dan sains di Jawa Barat.',
        'region' => 'Jawa Barat',
        'city' => 'Bandung'
      ],
      [
        'name' => 'Universitas Negeri Semarang',
        'description' => 'Universitas yang berfokus pada pengembangan pendidikan dan penelitian di Jawa Tengah.',
        'region' => 'Jawa Tengah',
        'city' => 'Semarang'
      ],
    ];

    $divisions = [
      [
        'name' => 'Accounting',
        'description' => 'Mengelola laporan keuangan, anggaran, dan pembukuan perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Recepcionist',
        'description' => 'Bertugas menerima tamu, menjawab telepon, dan mengelola resepsi kantor.',
        'capacity' => 6,
      ],
      [
        'name' => 'Perawatan Listrik',
        'description' => 'Memastikan sistem kelistrikan perusahaan berfungsi dengan baik.',
        'capacity' => 6,
      ],
      [
        'name' => 'Produksi',
        'description' => 'Bertanggung jawab atas proses produksi barang di perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Safety, Health, and Environment',
        'description' => 'Mengelola keselamatan, kesehatan kerja, dan lingkungan perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Sumber Daya Manusia',
        'description' => 'Mengelola sumber daya manusia, termasuk perekrutan dan pelatihan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Produksi dan Quality Control',
        'description' => 'Mengawasi proses produksi dan memastikan kualitas produk.',
        'capacity' => 6,
      ],
      [
        'name' => 'Corporate Secretary',
        'description' => 'Mengelola hubungan perusahaan dengan pemangku kepentingan dan tata kelola perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Treasury',
        'description' => 'Bertugas mengelola keuangan perusahaan termasuk arus kas dan investasi.',
        'capacity' => 6,
      ],
      [
        'name' => 'Perawatan Mesin',
        'description' => 'Merawat dan memperbaiki mesin agar beroperasi dengan optimal.',
        'capacity' => 6,
      ],
      [
        'name' => 'Kasir',
        'description' => 'Bertugas mengelola transaksi keuangan harian perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Electric Resistance Welding',
        'description' => 'Mengelola proses Electric Resistance Welding dalam produksi.',
        'capacity' => 6,
      ],
      [
        'name' => 'Logistik',
        'description' => 'Mengelola distribusi dan penyimpanan barang perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Secretary',
        'description' => 'Bertugas membantu administrasi dan mendukung kebutuhan pimpinan perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Mekanik',
        'description' => 'Memastikan peralatan mekanik perusahaan dalam kondisi baik.',
        'capacity' => 6,
      ],
      [
        'name' => 'Maintenance',
        'description' => 'Bertanggung jawab atas pemeliharaan fasilitas dan peralatan perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Hubungan Masyarakat',
        'description' => 'Mengelola hubungan masyarakat dan komunikasi perusahaan.',
        'capacity' => 6,
      ],
      [
        'name' => 'Production Planning and Control',
        'description' => 'Mengawasi perencanaan produksi dan pengendalian agar berjalan sesuai jadwal.',
        'capacity' => 6,
      ],
      [
        'name' => 'Perawatan Elektrik',
        'description' => 'Memastikan semua sistem elektrik perusahaan berjalan dengan baik.',
        'capacity' => 6,
      ],
    ];

    User::factory()->create([
      'name' => 'Admin',
      'email' => 'admin@example.com',
      'role' => 'Admin',
    ]);

    Division::insert($divisions);
    Institution::insert($institutions);
    User::factory()->count(5)->create();

    Mentor::factory()->create([
      'user_id' => User::factory()->create([
        'name' => 'Mentor',
        'email' => 'mentor@example.com',
        'role' => 'Mentor',
      ])->id,
    ]);

    Attendance::factory()->create([
      'participant_id' => Participant::factory()->create([
        'user_id' => User::factory()->create([
          'name' => 'Participant',
          'email' => 'participant@example.com',
          'role' => 'Participant',
        ])->id,
      ])->id,
    ]);

    Mentor::factory()->count(20)->create()->each(function ($mentor) {
      Participant::factory()->count(3)->create([
        'mentor_id' => $mentor->id,
      ])->each(function ($participant) {
        Attendance::factory()->create([
          'participant_id' => $participant->id,
        ]);
      });
    });
  }
}
