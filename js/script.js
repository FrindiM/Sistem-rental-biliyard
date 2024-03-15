window.addEventListener("beforeunload", async function (e) {
  e.preventDefault(); // Mencegah unload langsung

  try {
    await disconnect();
    // Jika berhasil disconnect, izinkan unload
    e.returnValue = "";
  } catch (error) {
    console.error(error);
    // Jangan izinkan unload jika terjadi kesalahan
    e.returnValue = "Terjadi kesalahan saat memutus koneksi.";
  }
});

async function disconnect() {
  try {
    // Menutup port serial
    await serialPort.close();

    // Mengubah status tombol atau tindakan lainnya
    // Misalnya, mengubah status koneksi atau menampilkan pesan
    alert("Alat terputus!");
  } catch (error) {
    console.error(error);
    throw error; // Propagasi error agar dapat ditangkap di event handler
  }
}

console.log("gaga")

$(document).ready(function () {
  // Mengaktifkan tombol berdasarkan ID
  function enableButtonById(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.disabled = false;
    }
  }

  function setReadonly(inputId) {
    $("#" + inputId).prop("readonly", true);
  }

  function unsetReadonly(inputId) {
    $("#" + inputId).prop("readonly", false);
  }

  // Menonaktifkan tombol berdasarkan ID
  function disableButtonById(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.disabled = true;
    }
  }

  // Menampilkan tombol berdasarkan ID
  function showButtonById(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.style.display = "inline-block";
    }
  }

  // Menyembunyikan tombol berdasarkan ID
  function hideButtonById(buttonId) {
    var button = document.getElementById(buttonId);
    if (button) {
      button.style.display = "none";
    }
  }

  // Menyembunyikan tombol-tombol dengan ID 'button_1' hingga 'button_10'
  for (var i = 1; i <= 10; i++) {
    var buttonId = "frees_" + i;
    hideButtonById(buttonId);
  }

  for (var i = 1; i <= 10; i++) {
    var buttonId = "stop_" + i;
    hideButtonById(buttonId);
  }

  for (var i = 1; i <= 10; i++) {
    var buttonId = "pause_" + i;
    hideButtonById(buttonId);
  }

  // for (var i = 1; i <= 10; i++) {
  //   var buttonId = "transaksi_" + i;
  //   disableButtonById(buttonId);
  // }

  let serialPort;

  async function connect() {
    try {
      // Meminta izin akses ke port serial
      serialPort = await navigator.serial.requestPort();

      // Membuka port serial
      await serialPort.open({
        baudRate: 9600,
      });

      // Mengubah status tombol

      // Mendengarkan data dari port serial
      // Menampilkan alert saat serial tersambung
      alert("Alat terhubung!");
    } catch (error) {
      console.error(error);
    }
  }

  async function sendData(data) {
    try {
      // Mengirim data ke port serial
      const writer = serialPort.writable.getWriter();
      await writer.write(new TextEncoder().encode(data));
      writer.releaseLock();

      // Menampilkan status ke console
      // console.log(`Data sent successfully: ${data}`);
    } catch (error) {
      console.error(error);
    }
  }

  function startTimerForwardWithButton(form) {
    var timer = form.find(".timer");

    // Dapatkan nilai waktu awal dari data-time
    var time = parseInt(timer.data("time"));

    // Mulai interval timer maju
    var intervalId = setInterval(function () {
      // Tambah waktu satu detik
      time++;
      var hours = Math.floor(time / 3600); // menghitung jam
      var minutes = Math.floor((time % 3600) / 60); // menghitung menit
      var seconds = time % 60; // menghitung detik
      timer.text(
        ("0" + hours).slice(-2) +
        ":" +
        ("0" + minutes).slice(-2) +
        ":" +
        ("0" + seconds).slice(-2)
      );
    }, 1000);

    // Simpan intervalId dan waktu pada data form untuk dapat dihentikan nanti
    form.data("intervalIdForward", intervalId);
    form.data("timeForward", time);
  }

  $(".start-forward-btn").on("click", function (e) {
    e.preventDefault();
    let playerName = $(".nama-input").val();
    var form = $(this).closest("form");
    if (playerName !== '') {
      stopTimerForwardWithButton(form);

      // (kode AJAX yang sudah ada)
      var buttonId = this.id;
      var datameja = form.find("input[name^=nomor_meja]").val();
      var tombol1 = "frees_" + datameja;
      var tombol2 = "mulai_" + datameja;
      var form1 = "nama_" + datameja;
      hideButtonById(buttonId);
      hideButtonById(tombol2);
      showButtonById(tombol1);
      var tombol3 = "transaksi_" + datameja;
      disableButtonById(tombol3);
      setReadonly(form1);

      var meja = datameja + "N";
      // console.log(meja);
      sendData(meja);

      // Mulai timer maju
      startTimerForwardWithButton(form);
    } else {
      alert("Masukan Nama")
    }
  });

  function stopTimerForwardWithButton(form) {
    // Hentikan timer maju
    clearInterval(form.data("intervalIdForward"));

    // Dapatkan waktu terakhir dan reset timer ke 00:00:00
    var time = form.data("timeForward") || 0;
    form.find(".timer").text("00:00:00");

    // Simpan waktu terakhir pada data form
    form.data("timeForward", time);
  }

  // Tombol "Stop Maju" untuk masing-masing formulir
  $(".stop-forward-btn").on("click", function (e) {
    e.preventDefault();
    var form = $(this).closest("form");
    var datameja = form.find("input[name^=nomor_meja]").val();
    var buttonId = this.id;
    var meja = datameja + "F";
    // console.log(meja);
    var tombol1 = "free_" + datameja;
    var tombol2 = "mulai_" + datameja;
    var form1 = "nama_" + datameja;
    unsetReadonly(form1);
    hideButtonById(buttonId);
    showButtonById(tombol1);
    showButtonById(tombol2);
    var tombol3 = "transaksi_" + datameja;
    enableButtonById(tombol3);

    // Dapatkan waktu terakhir dari teks timer sebelum diubah menjadi "00:00:00"
    var timeText = form.find(".timer").text();

    // Konversi waktu terakhir ke dalam detik
    var timeArray = timeText.split(":");
    var totalSeconds =
      parseInt(timeArray[0]) * 3600 +
      parseInt(timeArray[1]) * 60 +
      parseInt(timeArray[2]);

    // Konversi detik ke menit
    var totalMinutes = Math.floor(totalSeconds / 60);

    // Tampilkan waktu terakhir ke console dalam menit
    // console.log("Waktu Terakhir (menit):", totalMinutes);

    var nama = form.find(`input[name^=nama_${datameja}]`).val();
    // console.log(nama);

    $.ajax({
      type: "POST",
      url: "fungsi/free_on.php", // Ganti dengan URL server-side script Anda
      data: {
        nama: nama,
        datameja: datameja,
        totalMinutes: totalMinutes,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
      },
    });

    // Hentikan timer maju
    stopTimerForwardWithButton(form);

    // (Tambahkan tindakan apa pun yang Anda butuhkan di sini)
    sendData(meja);
  });

  $(".start-form").submit(function (e) {
    e.preventDefault();
    var data = $(this);
    var nomorMeja = data.find("input[name^=nomor_meja]").val();

    var form = $(this);
    var formData = new FormData(this);
    // Melakukan iterasi pada elemen select
    form.find('select').each(function () {
      var selectName = $(this).attr('name');
      var selectedText = $(this).find('option:selected').text();
      formData.set(selectName, selectedText);
    });
    $.ajax({
      type: "post",
      url: "fungsi/cek_transaksi.php",
      data: {
        nomorMeja: nomorMeja,
      },
      dataType: "json",
      success: function (response) {
        console.log(response)
        if (response.status === 'success') {
          alert('Selesaikan Transaksi Sebelumnya!');
          return false
        } else {
          console.log("dilanjut")
          let namaPlayer = form.find("input[name^=nama]").val();
          if (namaPlayer === '') {
            alert('Nama tidak boleh kosong!');
            e.preventDefault(); // Mencegah formulir disubmit jika input kosong
          } else {


            // console.log("Data sebelum di-serialize:", form);
            $.ajax({
              type: "POST",
              url: "fungsi/lampu_on.php",
              data: formData,
              processData: false, // Mencegah jQuery melakukan pemrosesan data secara otomatis
              contentType: false, // Mencegah jQuery menetapkan jenis konten secara otomatis
              success: function (data) {
                // console.log("Data yang dikirim ke server:", formData);
                // Tidak perlu tindakan khusus setelah berhasil
              },
            });

            var datameja = form.find("input[name^=nomor_meja]").val();
            var buttonId = "mulai_" + datameja;
            var tombol1 = "stop_" + datameja;
            var tombol2 = "pause_" + datameja;
            var tombol3 = "free_" + datameja;
            var tombol4 = "transaksi_" + datameja;
            var form1 = "nama_" + datameja;
            setReadonly(form1);
            hideButtonById(buttonId);
            hideButtonById(tombol3);
            showButtonById(tombol1);
            showButtonById(tombol2);
            disableButtonById(tombol4);
            var meja = datameja + "N";
            console.log(meja);

            sendData(meja);

            var waktu = parseInt(form.find("input[name^=waktu]").val()) * 60;
            var timer = form.find(".timer");
            timer.data("time", waktu); // Mulai waktu pada data-time
          }
        }
      }
    });



  });

  setInterval(function () {
    $(".timer").each(function () {
      var timer = $(this);
      var time = parseInt(timer.data("time"));

      if (!timer.data("paused")) {
        if (time > 0) {
          time--;
          var hours = Math.floor(time / 3600); // menghitung jam
          var minutes = Math.floor((time % 3600) / 60); // menghitung menit
          var seconds = time % 60; // menghitung detik
          timer.text(
            ("0" + hours).slice(-2) +
            ":" +
            ("0" + minutes).slice(-2) +
            ":" +
            ("0" + seconds).slice(-2)
          );
          timer.data("time", time);
        } else if (timer.data("time") == 0) {
          // Timer mencapai nol, kirim permintaan AJAX hanya satu kali
          // console.log("Condition met for timer with data-time 0");
          timer.data("time", -1); // Menghindari pengiriman berulang
          var form = timer.closest("form");
          var nomor = form.find('input[name^="nomor_meja"]').val();

          var tombol1 = "stop_" + nomor;
          var tombol2 = "pause_" + nomor;
          var tombol3 = "free_" + nomor;
          var tombol4 = "transaksi_" + nomor;
          var tombol5 = "mulai_" + nomor;
          var form1 = "nama_" + nomor;
          unsetReadonly(form1);
          hideButtonById(tombol1);
          hideButtonById(tombol2);
          showButtonById(tombol3);
          enableButtonById(tombol4);
          showButtonById(tombol5);

          // console.log(nomor);
          var meja = nomor + "F";
          console.log(meja);

          sendData(meja);
        }
      }
    });
  }, 1000);

  // $('#pauseAllButton').on('click', function() {
  //     // Iterate through all timers and pause them
  //     $('.timer').each(function() {
  //         $(this).data('paused', true);
  //     });

  //     // Optionally, you can send an AJAX request to notify the server about the pause all action
  //     // $.ajax({
  //     //     type: "POST",
  //     //     url: "fungsi/pause_all.php",
  //     //     success: function(data) {
  //     //         // Handle success
  //     //     }
  //     // });
  // });

  $("#pauseAllButton").on("click", function () {
    // Iterasi melalui semua timer
    $(".timer").each(function () {
      var timer = $(this);
      var time = parseInt(timer.data("time"));

      if (time > 0) {
        // Toggle antara pause dan lanjutkan
        if (timer.data("paused")) {
          // Lanjutkan timer
          timer.data("paused", false);
          var nomorMeja = timer
            .closest("form")
            .find('input[name^="nomor_meja"]')
            .val();
          var meja = nomorMeja + "N";
          // console.log(meja);
          sendData(meja);
        } else {
          // Pause timer
          timer.data("paused", true);
          var nomorMeja = timer
            .closest("form")
            .find('input[name^="nomor_meja"]')
            .val();
          var meja = nomorMeja + "F";
          // console.log(meja);
          sendData(meja);
        }
      } else if (time === 0) {
        // Tombol Pause All tidak berlaku untuk timer yang sudah mencapai 0
        console.log(
          "Timer dengan data-time 0 tidak dapat di-pause atau dilanjutkan."
        );
      } else {
        // Timer maju: Hentikan interval
        var form = timer.closest("form");
        var intervalIdForward = form.data("intervalIdForward");
        clearInterval(intervalIdForward);
      }
    });

    // Update teks tombol
    var buttonText =
      $(this).text() === "Pause All" ? "Continue All" : "Pause All";
    $(this).text(buttonText);
  });

  $(".pause-btn").on("click", function (e) {
    e.preventDefault();
    var nomorMeja = $(this).data("nomor-meja");
    var timer = $("#timer_" + nomorMeja);
    var time = parseInt(timer.data("time"));

    if (time > 0) {
      // Toggle antara pause dan lanjutkan
      if (timer.data("paused")) {
        // Lanjutkan timer
        timer.data("paused", false);
        $(this).text("Pause");
        var meja = nomorMeja + "N";
        // console.log(meja);
        sendData(meja);
      } else {
        // Pause timer
        timer.data("paused", true);
        $(this).text("Lanjutkan");
        var meja = nomorMeja + "F";
        // console.log(meja);
        sendData(meja);
      }
    }
  });

  $(".stop-btn").on("click", function (e) {
    e.preventDefault();
    var nomorMeja = $(this).data("nomor-meja");
    // console.log(nomorMeja);
    var timer = $("#timer_" + nomorMeja);
    var meja = nomorMeja + "F";
    // console.log(meja);
    sendData(meja);

    var tombol1 = "stop_" + nomorMeja;
    var tombol2 = "pause_" + nomorMeja;
    var tombol3 = "free_" + nomorMeja;
    var tombol4 = "transaksi_" + nomorMeja;
    var tombol5 = "mulai_" + nomorMeja;
    hideButtonById(tombol1);
    hideButtonById(tombol2);
    showButtonById(tombol3);
    enableButtonById(tombol4);
    showButtonById(tombol5);


    var form1 = "nama_" + nomorMeja;
    unsetReadonly(form1);
    // Hentikan timer dan reset waktu
    timer.data("paused", false);
    timer.data("time", -1);
    timer.text("00:00:00");
  });

  $(".lampu-select").on("change", function () {
    var selectedLampu = $(this).find("option:selected").text();
    var nomorMeja = $(this).data("nomor-meja");
    // Memanggil fungsi untuk mengambil data sesuai dengan nama yang dipilih
    getData(selectedLampu, nomorMeja);
  });

  $(".nama-select").on("change", function () {
    var nomormeja = document.querySelector(".nomor");
    var nilainomor = nomormeja.value;
    // console.log(nilainomor);
    var tabel = "keranjangTable2";
    showButtonById(tabel);
    var selectednama = $(this).find("option:selected").text();

    // Menggunakan AJAX untuk mendapatkan data, termasuk ID, dari server
    $.ajax({
      type: "POST",
      url: "fungsi/get_nama.php",
      data: {
        selectednama: selectednama,
      },
      success: function (response) {
        // console.log(response);
        var parsedResponse = JSON.parse(response);

        if (parsedResponse.length > 0) {
          var selectedId = parsedResponse[0].id; // Ambil ID dari respons pertama
          $("#idhidden").val(selectedId); // Simpan ID di elemen tersembunyi
          // updateSelectOptions(parsedResponse);
        } else {
          // console.log("Data tidak ditemukan");
        }
      },
    });

    // Memanggil fungsi untuk mengambil data sesuai dengan nama dan ID yang dipilih
    getbill(nilainomor, selectednama);
    gettotal();
    loadKeranjang2();
  });

  function hitungTotalBayar() {
    // Mendapatkan nilai dari input dengan ID hargabill dan totalmenu
    var hargaBill = parseFloat($("#hargabill").val()) || 0;
    var totalMenu = parseFloat($("#totalmenu").val()) || 0;

    // Menambahkan nilai dari dua variabel dan menyimpannya ke dalam variabel totalbayar
    var totalBayar = hargaBill + totalMenu;

    // Menampilkan hasil atau menyimpan ke variabel lain sesuai kebutuhan
    $("#totalharga").val(totalBayar);
  }

  function getbill(nilainomor, selectednama) {
    $.ajax({
      type: "POST",
      url: "fungsi/get_bill.php", // Ganti dengan URL server-side script Anda
      data: {
        nilainomor: nilainomor,
        selectednama: selectednama,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        // console.log(parsedResponse);

        // Cek apakah ada data dalam respons
        if (parsedResponse.length > 0) {
          // Ambil elemen pertama dari array respons
          var firstRow = parsedResponse[0];

          // Mengambil nilai dari kolom 'nama' dan 'waktu'
          var waktu = firstRow.waktu;
          var paket = firstRow.id_paket;
          var harga = firstRow.harga;
          // console.log(waktu);
          $("#waktubill").val(waktu);
          $("#hargabill").val(harga);

          getharga(paket);
          // Lakukan operasi lain sesuai kebutuhan
          // console.log("Nama: " + nama + ", Waktu: " + waktu);
        } else {
          console.log("Tidak ada data.");
        }
      },
    });
  }

  function getharga(paket) {
    $.ajax({
      type: "POST",
      url: "fungsi/get_paket.php", // Ganti dengan URL server-side script Anda
      data: {
        paket: paket,
      },
      success: function (response) {
        // Mengisi input waktu dengan harga yang diterima dari server
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        // console.log(parsedResponse);

        // Cek apakah ada data dalam respons
        if (parsedResponse.length > 0) {
          // Ambil elemen pertama dari array respons
          var firstRow = parsedResponse[0];

          // Mengambil nilai dari kolom 'nama' dan 'waktu'
          var hargapaket = firstRow.harga;
          var namapaket = firstRow.nama;

          // console.log(hargapaket);

          $("#paketbill").val(namapaket);
          hitungTotalBayar();
          // Lakukan operasi lain sesuai kebutuhan
          // console.log("Nama: " + nama + ", Waktu: " + waktu);
        } else {
          // console.log("Tidak ada data.");
        }
      },
    });
  }

  $(".fnb-btn").on("click", function () {
    console.log("hai");
    var namaMeja = $(this).data("nama-meja");
    var nomormeja = $(this).data("nomor-meja");
    var nama = $("#nama_" + nomormeja).val();
    var hargawal = "0";
    $("#hargabillminuman").val(hargawal);
    console.log(nomormeja);
    console.log(nama);
    console.log("harga");
    $("#modal-nama-meja-fnb").text(namaMeja);
    $("#nomorminuman").val(nomormeja);
    $("#namapemainmenu").val(nama);
    getminuman();
    loadKeranjang();
  });

  function getminuman(nomormeja) {
    $.ajax({
      type: "POST",
      url: "fungsi/get_minuman.php", // Ganti dengan URL server-side script Anda
      data: {
        nomormeja: nomormeja,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        console.log(response);
        var parsedResponse = JSON.parse(response);
        console.log(parsedResponse);
        updateSelectOptionsMinuman(parsedResponse);
      },
    });
  }

  function updateSelectOptionsMinuman(optionsData) {
    var selectElement = $("#minuman");

    // Clear existing options
    selectElement.empty();

    // Add a default option
    selectElement.append("<option value=''>-- Pilih Minuman --</option>");

    // Add options based on the response
    for (var i = 0; i < optionsData.length; i++) {
      selectElement.append(
        "<option value='" +
        optionsData[i].nama +
        "'>" +
        optionsData[i].nama +
        "</option>"
      );
    }
  }

  $(".btnLaporan").on("click", function () {
    let user = $(this).data("user");
    $("#namaUser").val(user);
    console.log("open modal");
    $("#exampleModalLongTitle").text(user + " Laporan");
    $("#cariLaporan").click(function () {
      let selectedDate = $("#tanggalInput").val(); // Mendapatkan tanggal yang dipilih
      let selectedTable = $("#selectMeja").val();
      console.log(selectedTable);
      if (selectedTable === "all") {
        console.log('semua');
        if (selectedDate !== "") {
          // console.log("Tanggal yang dipilih:", selectedDate);
          $.ajax({
            type: "POST",
            url: "fungsi/get_laporan.php",
            data: {
              user: user,
              date: selectedDate,
            },
            success: function (response) {
              // Mengonversi respons JSON menjadi objek JavaScript
              let parsedResponse = JSON.parse(response);

              // Memeriksa apakah respons JSON berisi data atau tidak
              if (parsedResponse.info && parsedResponse.info === 'kosong') {
                // Menampilkan pesan bahwa data kosong
                $(".body-laporan").html("<p>Data kosong</p>");
              } else {
                // Memformat data JSON sesuai kebutuhan Anda dan menambahkannya ke dalam elemen HTML
                let htmlContent = "<table class'table' border='1'><tr><th>Tanggal</th><th>Meja</th><th>Nama</th><th>Paket</th><th>Waktu(M)</th><th>Item Tambahan</th><th>Total Bayar</th></tr>";
                parsedResponse.forEach(function (item) {
                  htmlContent += "<tr><td>" + item.tanggal + "</td><td>" + item.nomor_meja + "</td><td>" + item.nama + "</td><td>" + item.id_paket + "</td><td>" + item.waktu + "</td><td>" + item.nama_item + "</td><td>" + item.total_bayar + "</td></tr>";
                });
                htmlContent += "</table>";

                // Menambahkan konten HTML ke dalam elemen ".body-laporan"
                $(".body-laporan").html(htmlContent);
              }
            }
          });
        } else {
          console.log('Tanggal kosong');
          $(".body-laporan").html("<p>Masukan Tanggal</p>");
        }
      } else {
        console.log('angka');
        if (selectedDate !== "") {
          console.log(selectedDate);
          $.ajax({
            type: "post",
            url: "fungsi/get_laporan_meja.php",
            data: {
              user: user,
              date: selectedDate,
              tabel: selectedTable,
            },
            dataType: "json",
            success: function (response) {
              if (response.info && response.info === 'kosong') {
                // Menampilkan pesan bahwa data kosong
                $(".body-laporan").html("<p>Data kosong</p>");
              } else {
                // Memformat data JSON sesuai kebutuhan Anda dan menambahkannya ke dalam elemen HTML
                let htmlContent = "<table class'table' border='1'><tr><th>Tanggal</th><th>Meja</th><th>Nama</th><th>Paket</th><th>Waktu(M)</th><th>Item Tambahan</th><th>Total Bayar</th></tr>";
                response.forEach(function (item) {
                  htmlContent += "<tr><td>" + item.tanggal + "</td><td>" + item.nomor_meja + "</td><td>" + item.nama + "</td><td>" + item.id_paket + "</td><td>" + item.waktu + "</td><td>" + item.nama_item + "</td><td>" + item.total_bayar + "</td></tr>";
                });
                htmlContent += "</table>";

                // Menambahkan konten HTML ke dalam elemen ".body-laporan"
                $(".body-laporan").html(htmlContent);
              }
            }
          });
        } else {
          console.log('Tanggal Kosong');
          $(".body-laporan").html("<p>Masukan Tanggal</p>");
        }
      }

    });

  });

  $(".btnPrintLaporan").on("click", function () {
    let user = $("#namaUser").val();
    let selectedDate = $("#tanggalInput").val();
    let selectedTable = $("#selectMeja").val();
    if (selectedTable === "all") {
      let cari = "cek";
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, '0');
      let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      let yyyy = today.getFullYear();
      let tgl = yyyy + '-' + mm + '-' + dd;
      let url = "fungsi/cetak.php?all=" + encodeURIComponent(cari) + "&tgl=" + encodeURIComponent(selectedDate) + "&meja=" + encodeURIComponent(selectedTable) + "&kasir=" + encodeURIComponent(user);
      window.open(url, '_blank');

    } else {
      let cari = "cek";
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, '0');
      let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
      let yyyy = today.getFullYear();
      let tgl = yyyy + '-' + mm + '-' + dd;
      let url = "fungsi/cetak_meja.php?hari=" + encodeURIComponent(cari) + "&tgl=" + encodeURIComponent(selectedDate) + "&meja=" + encodeURIComponent(selectedTable) + "&kasir=" + encodeURIComponent(user);
      window.open(url, '_blank');
    }
  });


  $(".minuman-select").on("change", function () {
    let nomormeja = document.querySelector(".nomor");
    let nilainomor = nomormeja.value;
    console.log(nilainomor);
    let selectednama = $(this).find("option:selected").text();
    console.log(selectednama);
    getbillminuman(selectednama);
  });

  function getbillminuman(selectednama) {
    $.ajax({
      type: "POST",
      url: "fungsi/get_billminuman.php", // Ganti dengan URL server-side script Anda
      data: {
        selectednama: selectednama,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        // console.log(parsedResponse);

        // Cek apakah ada data dalam respons
        if (parsedResponse.length > 0) {
          // Ambil elemen pertama dari array respons
          var firstRow = parsedResponse[0];
          var harga = firstRow.harga;
          console.log(harga);
          $("#hargabillminuman").val(harga);
          // Lakukan operasi lain sesuai kebutuhan
        } else {
          console.log("Tidak ada data.");
        }
      },
    });
  }

  $(".btn-open-modal").on("click", function () {
    var namaMeja = $(this).data("nama-meja");
    var nomormeja = $(this).data("nomor-meja");
    var paketmeja = "";
    var hargawal = "0";
    console.log(nomormeja);
    console.log(namaMeja); // Cek apakah nama meja sudah benar diambil
    getnama(nomormeja);
    $("#modal-nama-meja").text(namaMeja);
    $("#nomor").val(nomormeja);
    $("#paketbill").val(paketmeja);
    $("#waktubill").val(paketmeja);
    $("#hargabill").val(hargawal);
    $("#menutambahan").val(paketmeja);
    $("#totalmenu").val(hargawal);
    $("#idhidden").val(paketmeja);
    $("#totalharga").val(hargawal);
    var tabel = "keranjangTable2";
    hideButtonById(tabel);
  });

  function getnama(nomormeja) {
    $.ajax({
      type: "POST",
      url: "fungsi/get_nama.php", // Ganti dengan URL server-side script Anda
      data: {
        nomormeja: nomormeja,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        // console.log(parsedResponse);
        updateSelectOptions(parsedResponse);
      },
    });
  }

  function updateSelectOptions(optionsData) {
    var selectElement = $("#nomorMeja");

    // Clear existing options
    selectElement.empty();

    // Add a default option
    selectElement.append("<option value=''>-- Pilih Nama --</option>");

    // Add options based on the response
    for (var i = 0; i < optionsData.length; i++) {
      selectElement.append(
        "<option value='" +
        optionsData[i].nama +
        "'>" +
        optionsData[i].nama +
        "</option>"
      );
    }
  }

  // Fungsi untuk mengambil data dari server
  function getData(lampu, nomorMeja) {
    console.log(lampu);
    console.log(nomorMeja);
    $.ajax({
      type: "POST",
      url: "fungsi/get_data.php", // Ganti dengan URL server-side script Anda
      data: {
        lampu: lampu,
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        console.log(response);
        var parsedResponse = JSON.parse(response);
        console.log(parsedResponse);
        $("#waktu_" + nomorMeja).val(parsedResponse.waktu);
        // Mengisi input harga dengan harga yang diterima dari server
        $("#harga_" + nomorMeja).val(parsedResponse.harga);
      },
    });
  }

  $(".conect").on("click", function () {
    connect();
  });

  // Mendapatkan elemen formulir dan tombol print
  var form = $("#myForm");
  var printButton = $("#printButton");
  var selesaiButton = $("#selesai");

  // Menambahkan event listener pada tombol print
  printButton.on("click", function () {
    // Mengambil nilai dari formulir
    var nomormeja = $("#nomor").val();
    var nama = $("#nomorMeja").val();
    var paket = $("#paketbill").val();
    var waktu = $("#waktubill").val();
    var harga = $("#hargabill").val();
    var tambahan = $("#menutambahan").val();
    var tambahanharga = $("#totalmenu").val();
    var totalharga = $("#totalharga").val();

    // Membuat URL dengan parameter yang diambil dari formulir
    var printURL =
      "fungsi/print.php?nomor=" +
      nomormeja +
      "&nama=" +
      nama +
      "&paket=" +
      paket +
      "&waktu=" +
      waktu +
      "&tambahan=" +
      tambahan +
      "&tambahanharga=" +
      tambahanharga +
      "&totalharga=" +
      totalharga +
      "&harga=" +
      harga;

    // Membuka URL di tab yang sama
    window.open(printURL, "_blank");
  });

  selesaiButton.on("click", function () {
    var id = $("#idhidden").val();
    var total = $("#totalharga").val();
    console.log(id);
    $.ajax({
      type: "POST",
      url: "fungsi/update_cs.php",
      data: {
        id: id,
        total: total,
      },
      success: function (response) {
        // Menerima respons JSON dan menangani data
        var parsedResponse = JSON.parse(response);

        if (parsedResponse.success) {
          // Sukses: Tampilkan pesan ke konsol
          console.log(parsedResponse.message);
          $("#myModal").modal("hide");
        } else {
          // Gagal: Tampilkan pesan error ke konsol
          console.error(parsedResponse.message);
        }
      },
      error: function (xhr, status, error) {
        // Tampilkan pesan error ke konsol jika ada kesalahan saat melakukan AJAX
        console.error("Error dalam AJAX:", status, error);
      },
    });
    alert("Pembayaran Selesai");
  });

  $("#tambahKeranjangBtn").on("click", function () {
    tambahKeranjang();
  });

  function tambahKeranjang() {
    var id_barang = $("#minuman").val();
    var jumlah = $("#jumlahbillminuman").val();
    var meja = $("#nomorminuman").val();
    var namapemain = $("#namapemainmenu").val();

    console.log(id_barang);
    console.log(jumlah);

    if (id_barang === "" || jumlah === "") {
      alert("Pilih dan masukkan jumlah.");
      return;
    }

    $.ajax({
      type: "POST",
      url: "fungsi/tambah_keranjang.php",
      data: {
        id_barang: id_barang,
        jumlah: jumlah,
        meja: meja,
        namapemain: namapemain,
      },
      success: function (response) {
        loadKeranjang();
      },
    });
  }

  function loadKeranjang() {
    var nomor = $("#nomorminuman").val();
    var namapemain = $("#namapemainmenu").val();
    $.ajax({
      type: "GET",
      data: {
        nomor: nomor,
        namapemain: namapemain
      },
      url: "fungsi/load_keranjang.php",
      dataType: "json", // Menentukan tipe data yang diharapkan
      success: function (data) {
        // Memproses data yang diterima
        renderTable(data);
      },
    });
  }

  function renderTable(data) {
    // Menangani data JSON dan membuat HTML tabel
    var tableHTML =
      "<table class='table table-striped bordered mt-3'>\
                      <tr>\
                          <th>Nama</th>\
                          <th>Harga</th>\
                          <th>Jumlah</th>\
                      </tr>";

    for (var i = 0; i < data.length; i++) {
      tableHTML +=
        "<tr>\
                    <td>" +
        data[i].nama +
        "</td>\
                    <td>" +
        data[i].harga +
        "</td>\
                    <td>" +
        data[i].jumlah +
        "</td>\
                </tr>";
    }

    tableHTML += "</table>";

    // Menyisipkan tabel ke dalam elemen dengan id 'keranjangTable'
    $("#keranjangTable").html(tableHTML);
  }

  function loadKeranjang2() {
    var nomor = $("#nomor").val();
    var namapemain = $("#nomorMeja").val();
    $.ajax({
      type: "GET",
      data: {
        nomor: nomor,
        namapemain: namapemain
      },
      url: "fungsi/load_keranjang.php",
      dataType: "json", // Menentukan tipe data yang diharapkan
      success: function (data) {
        // Memproses data yang diterima
        renderTable2(data);
      },
    });
  }

  function renderTable2(data) {
    // Menangani data JSON dan membuat HTML tabel
    var tableHTML =
      "<table class='table table-striped bordered mt-3'>\
                      <tr>\
                          <th>Nama</th>\
                          <th>Harga</th>\
                          <th>Jumlah</th>\
                      </tr>";

    for (var i = 0; i < data.length; i++) {
      tableHTML +=
        "<tr>\
                    <td>" +
        data[i].nama +
        "</td>\
                    <td>" +
        data[i].harga +
        "</td>\
                    <td>" +
        data[i].jumlah +
        "</td>\
                </tr>";
    }

    tableHTML += "</table>";

    // Menyisipkan tabel ke dalam elemen dengan id 'keranjangTable'
    $("#keranjangTable2").html(tableHTML);
  }

  $("#checkoutBtn").on("click", function () {
    checkout();
  });

  function checkout() {
    var nomor = $("#nomor").val();
    var namapemain = $("#nomorMeja").val();
    var id = $("#idhidden").val();
    console.log("chec" + nomor + ", " + id + ", " + namapemain)
    $.ajax({
      type: "POST",
      url: "fungsi/checkout.php",
      data: {
        nomor: nomor,
        namapemain: namapemain,
        id: id
      },
      success: function (response) {
        if (response === "success") {
          console.log(response);
          loadKeranjang2();
          gettotal();
        } else {
          console.log('Gagal');
        }
      },
    });
  }

  function gettotal() {
    var nomor = $("#nomor").val();
    var namapemain = $("#nomorMeja").val();
    var id = $("#idhidden").val();
    $.ajax({
      type: "POST",
      url: "fungsi/get_total.php",
      data: {
        nomor: nomor,
        namapemain: namapemain,
        id: id
      },
      success: function (response) {
        // Mengisi input waktu dengan waktu yang diterima dari server
        // console.log(response);
        var parsedResponse = JSON.parse(response);
        // console.log(parsedResponse);

        // Cek apakah ada data dalam respons
        if (parsedResponse.length > 0) {
          // Ambil elemen pertama dari array respons
          var firstRow = parsedResponse[0];

          // Mengambil nilai dari kolom 'nama' dan 'waktu'
          var waktu = firstRow.nama_item;
          var harga = firstRow.total_harga;
          console.log(waktu);
          $("#menutambahan").val(waktu);
          $("#totalmenu").val(harga);
          hitungTotalBayar();
        } else {
          console.log("Tidak ada data.");
        }
      },
    });
  }
});