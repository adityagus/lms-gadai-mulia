<!-- <template>
        <div class="flex flex-col gap-5 max-w-[800px] pb-[160px]">
        <h1 class="font-bold text-[32px] leading-[48px]">
          Pengenalan UI UX
        </h1>
        <article id="Content-wrapper">
          <p>
            Dalam artikel ini, kita akan membahas tentang Laravel, mengapa
            framework ini dibuat, alasan mengapa belajar Laravel, keunggulan
            utama Laravel, persiapan yang diperlukan, langkah-langkah belajar
            Laravel, dan bagaimana menemukan mentor serta proyek sampingan untuk
            meningkatkan keterampilan Anda.
          </p>
          <h3>Dasar Design Principle</h3>
          <p>
            Laravel adalah framework open-source untuk PHP yang dibuat oleh
            Taylor Otwell. Framework ini dirancang untuk pengembang web yang
            ingin bekerja dengan cara yang elegan dan menyenangkan.
          </p>
        </article>
      </div>
      <div class="fixed bottom-0 w-[calc(100%-400px)] h-[151px] flex items-end justify-end pb-5 bg-[linear-gradient(0deg,#FFFFFF_49.67%,rgba(255,255,255,0)_84.11%)]">
        <button
          type="button"
          class="w-fit rounded-full p-[14px_20px] font-semibold text-[#FFFFFF] bg-[#662FFF] text-nowrap"
        >
          Mark as Completed
        </button>
      </div>
</template> -->


<template>
  <div class="flex justify-end">
    <button class='btn bg-red-500 py-2 px-5 rounded-lg text-white hover:bg-red-400'>Download Lampiran</button>
  </div>
  <div class="" v-html='html'></div>
</template>

<script setup>
const html = `
<!DOCTYPE html>
<html>
<head>
<style>
  body {
    font-family: sans-serif;
    margin: 20px;
  }
  .memo-header {
    text-align: center;
    margin-bottom: 30px;
  }
  .memo-header h1 {
    font-size: 24px;
    margin-bottom: 5px;
  }
  .memo-details {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .memo-details div {
    width: 48%;
  }
  .memo-details p {
    margin: 5px 0;
  }
  .section-title {
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 10px;
  }
  .subsection-title {
    font-size: 16px;
    font-weight: bold;
    margin-top: 15px;
    margin-bottom: 8px;
  }
  .content {
    line-height: 1.6;
  }
  .signature-block {
    display: flex;
    justify-content: space-around;
    margin-top: 50px;
    text-align: center;
  }
  .signature-block div {
    flex: 1;
  }
  .signature-block p {
    margin: 5px 0;
  }
  .attachment-title {
    font-size: 20px;
    font-weight: bold;
    margin-top: 40px;
    margin-bottom: 20px;
    text-align: center;
  }
  .form-section {
    margin-bottom: 20px;
  }
  .form-section label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
  }
  .form-section input[type="text"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .form-section textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    min-height: 80px;
  }
  .checkbox-group label {
    font-weight: normal;
    margin-right: 15px;
  }
  .footer-note {
    margin-top: 30px;
    font-style: italic;
  }
  .table-container {
    margin-bottom: 20px;
    width: 100%;
    border-collapse: collapse;
  }
  .table-container td {
    padding: 5px;
    border: 1px solid #ddd;
  }
  .table-container .label {
    font-weight: bold;
  }
</style>
</head>
<body>

  <div class="memo-header">
    <table class="table-container">
      <tr>
        <td class="label">Kepada Yth</td>
        <td>: Cluster Manager, Branch Manager, Unit Manager Penaksir & Marketing Gadai Mulia</td>
      </tr>
      <tr>
        <td class="label">Tembusan</td>
        <td>: Branch Monitoring Development, Network Development, SPI</td>
      </tr>
      <tr>
        <td class="label">Dari</td>
        <td>: SOP Development</td>
      </tr>
      <tr>
        <td class="label">Tanggal</td>
        <td>: 27 Agustus 2021</td>
      </tr>
      <tr>
        <td class="label">Perihal</td>
        <td>: Ketentuan SBG Batal dan SBG Kosong</td>
      </tr>
      <tr>
        <td class="label">Lampiran</td>
        <td>: Berita Acara</td>
      </tr>
    </table>
    <h1>MEMORANDUM</h1>
    <p>M.2021.054/SAM-HO</p>
    <p>MOHON DAPAT DITERUSKAN DAN DIINFORMASIKAN KEPADA SELURUH UNIT KERJA / STAFF DIBAWAH KOORDINASI ANDA</p>
  </div>

  <div class="content">
    <div class="section-title">A. Latar Belakang</div>
    <p>Banyaknya SBG yang tidak dapat terpakai karena kesalahan transaksi atau lainnya maka perlu dibuat suatu standarisasi penanganan SBG yang tidak terpakai/Batal.</p>

    <div class="section-title">B. Ketentuan Umum</div>
    <ol>
      <li>SBG yang sudah tercetak namun karena suatu hal sehingga penggunaannya dibatalkan maka sebagai SBG Batal</li>
      <li>SBG yang tidak ada nomor blanko maka dianggap sebagai SBG Kosong dan tidak bisa digunakan.</li>
      <li>SBG Batal diberikan tulisan "BATAL" pada lembar SBG</li>
      <li>SBG batal dan SBG kosong selama satu bulan disatukan</li>
      <li>membuat berita acara SBG batal dan SBG kosong dan dikirimkan maksimal tanggal 10 bulan berikutnya.</li>
      <li>Mengirimkan berita acara melalui email ke GA (PIC: Parroy dan Asep), cc: IT & BMD (PIC: Alex dan Ajeng) untuk dilakukan penghapusan nomor blanko pada sistem</li>
      <li>Berita acara, SBG Batal dan SBG kosong dijadikan satu dan di Filling dengan baik</li>
      <li>SBG batal dan SBG kosong selama bulan Agustus atau yang belum pernah dilaporkan sebelumnya maka wajib dilaporkan pada bulan September 2021.</li>
    </ol>

    <p>Memo ini berlaku efektif mulai tanggal 1 September 2021.</p>

    <p>Demikian untuk diketahui dan dilaksanakan dengan sebaik-baiknya.<br>
    Ketidakpatuhan atas memo ini yang dapat berakibat kemungkinan terjadinya resiko kerugian di Perusahaan, menjadi tanggung jawab pegawai yang bersangkutan.</p>

    <div class="signature-block">
      <div>
        <p>Dibuat Oleh</p>
        <p>Henny A</p>
        <p>SOP Development</p>
      </div>
      <div>
        <p>Mengetahui</p>
        <p>Asep Supriyadi</p>
        <p>Network Development</p>
        <br>
        <p>Chrisantus Alex Setiabudi</p>
        <p>BMD</p>
      </div>
      <div>
        <p>Menyetujui</p>
        <p>Yudhiprama Elpantja</p>
        <p>COO</p>
      </div>
    </div>
    <p style="text-align: right;">M.2021.054/SAM-HO</p>
  </div>

  <hr>

  <div class="attachment-title">Lampiran 1: Berita Acara</div>

  <div class="content">
    <p style="text-align: center; font-weight: bold;">HARAP MENGISI SEMUA DATA DENGAN LENGKAP</p>
    <h2 style="text-align: center;">BERITA ACARA</h2>

    <div class="form-section">
      <label>Cabang :</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>Kode Cabang:</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>Bagian :</label>
      <div class="checkbox-group">
        <label><input type="checkbox"> Pemeriksaan</label>
        <label><input type="checkbox"> Pelaporan</label>
        <label><input type="checkbox"> Koreksi</label>
        <label><input type="checkbox"> Lainnya</label>
      </div>
      <p>(khusus untuk Kantor Pusat)</p>
    </div>

    <div class="section-title">A. INFORMASI PENYUSUN BERITA ACARA</div>
    <div class="form-section">
      <label>Nama Lengkap</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>NIK/Jabatan</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>Email Address</label>
      <input type="text">
    </div>

    <div class="section-title">B. INFORMASI BERITA ACARA</div>
    <div class="form-section">
      <label>Tujuan Berita Acara :</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>Tanggal Berita Acara</label>
      <input type="text">
    </div>
    <div class="form-section">
      <label>Jenis Dokumen Terkait</label>
      <div class="checkbox-group">
        <label><input type="checkbox"> SBG</label>
        <label><input type="checkbox"> Dokumen Lainnya</label>
      </div>
    </div>
    <div class="form-section">
      <label>Deskripsi Berita Acara</label>
      <textarea></textarea>
    </div>

    <div class="section-title">KOLOM TANDA TANGAN</div>
    <table class="table-container">
      <tr>
        <td class="label">Penyusun Berita Acara</td>
        <td colspan="2">Mengetahui (Atasan Langsung)</td>
      </tr>
      <tr>
        <td>Nama:</td>
        <td>Nama:</td>
      </tr>
      <tr>
        <td>Tgl :</td>
        <td>Tgl :</td>
      </tr>
    </table>

    <div class="section-title">PERNYATAAN KEBENARAN DATA</div>
    <p>Dengan ditandatanganinya Berita Acara ini, maka Penyusun Berita Acara bertanggung jawab atas isi dan kebenaran laporan yang telah disusun sesuai dengan hak dan kewajibannya</p>
    <p style="text-align: right;">M.2021.

`
</script>