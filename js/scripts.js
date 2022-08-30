/*!
 * Start Bootstrap - Simple Sidebar v6.0.5 (https://startbootstrap.com/template/simple-sidebar)
 * Copyright 2013-2022 Start Bootstrap
 * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-simple-sidebar/blob/master/LICENSE)
 */
// 
// Scripts
// 

// wrp = document.getElementById("wrapper");
// tbl = document.getElementById("tblTambah");

// tbl.addEventListener("click", function() {
//     alert('ok');
// });

window.onload = function () {
    showDateTime();
}

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

// Display Date and Time
function showDateTime() {
    const today = new Date();
    const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"];
    const monthName = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    let day = weekday[today.getDay()];
    let date = today.getDate();
    let month = monthName[today.getMonth()];
    let year = today.getUTCFullYear();
    let h = today.getUTCHours() + 7;
    let m = today.getUTCMinutes();
    let s = today.getUTCSeconds();
    if (h >= 24) {
        h = h - 24;
    }
    m = convertTimeToDoubleDigit(m);
    s = convertTimeToDoubleDigit(s);
    document.getElementById("Day").innerHTML = day;
    document.getElementById("Date").innerHTML = date + " " + month + " " + year;
    document.getElementById("Time").innerHTML = h + " : " + m + " : " + s;
    setTimeout(showDateTime, 1000);
}

function convertTimeToDoubleDigit(i) { //To display minutes and seconds as two digit when below 10
    if (i < 10) {
        i = "0" + i
    };
    return i;
}

$('.hapus-data').on('click', function (e) {
    e.preventDefault();
    var getLink = $(this).attr('href');

    Swal.fire({
        title: 'Hapus Data?',
        text: "Data akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus'
    }).then((result) => {
        if (result.value) {
            window.location.href = getLink;
        }
    })
});

$(document).ready(function () {
    $('#example').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json'
        },
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            download: 'open'
        }]
    });
});

function tblTambah() {
    ab = document.getElementById("article");
    ab.className = ab.className.replace("alert-box-hide", "alert-box-show");
    wrp = document.getElementById("wrapper");
    wrp.style.filter = "blur(64px)";
    // wrp.classList.add("blur-64");
}


// wrp = document.getElementById("wrapper");
// card = document.getElementById("alertBox");
// card.onload = function() {
//     wrp.style.filter = "blur(64px)";
// }

$('#logout').on('click', function(e){
	e.preventDefault();
	var getLink = $(this).attr('href');

	Swal.fire({
  title: 'Yakin ingin logout?',
  showDenyButton: true,
  confirmButtonText: 'Yakin',
  denyButtonText: `Tidak`,
	}).then((result) => {
	  if (result.value) {
	    window.location.href = getLink;
	  }
	})
});