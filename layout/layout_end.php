</div> <!-- content -->
</div> <!-- wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<div id="toastNotif" 
     style="position:fixed; bottom:20px; right:20px; z-index:9999; display:none;">
  <div class="bg-dark text-white p-3 rounded shadow" style="min-width:250px;">
    <div id="toastText">Notifikasi baru</div>
  </div>
</div>

<script>

/* =========================
   SIDEBAR DESKTOP
========================= */
function toggleSidebarDesktop(){
  const sidebar = document.querySelector('.sidebar');
  if(sidebar) sidebar.classList.toggle('mini');
}

/* =========================
   SIDEBAR MOBILE
========================= */
function toggleSidebarMobile(){
  const sidebar = document.querySelector('.sidebar');
  const overlay = document.getElementById('overlay');

  if(sidebar) sidebar.classList.toggle('show');
  if(overlay) overlay.classList.toggle('show');
}

/* =========================
   AUTO CLOSE MOBILE MENU
========================= */
document.querySelectorAll('.sidebar a:not(.menu-toggle)').forEach(link => {
  link.addEventListener('click', () => {
    if(window.innerWidth < 768){
      const sidebar = document.querySelector('.sidebar');
      const overlay = document.getElementById('overlay');

      if(sidebar) sidebar.classList.remove('show');
      if(overlay) overlay.classList.remove('show');
    }
  });
});

/* =========================
   JAM REALTIME (AMAN)
========================= */
function updateClock(){
  const el = document.getElementById('clock');
  if(!el) return;

  const now = new Date();
  el.innerHTML = now.toLocaleTimeString('id-ID');
}
setInterval(updateClock, 1000);
updateClock();

/* =========================
   NOTIF AUTO REFRESH (AMAN)
========================= */
setInterval(() => {
  fetch('notif_count.php')
    .then(res => res.text())
    .then(data => {
      const badge = document.querySelector('.notif-badge');
      if(badge) badge.innerHTML = data;
    })
    .catch(err => console.log('Notif error:', err));
}, 5000);

let lastNotifId = null;

setInterval(() => {
  fetch('notif_latest.php')
    .then(res => res.json())
    .then(data => {

      if(!data) return;

      // kalau notif baru
      if(lastNotifId !== data.id){

        lastNotifId = data.id;

        // 🔊 bunyi
        document.getElementById('notifSound').play();

        // 💬 tampilkan popup
        let toast = document.getElementById('toastNotif');
        let text  = document.getElementById('toastText');

        text.innerHTML = `
          📢 Pengajuan baru dari <b>${data.pemohon}</b><br>
          ${data.jam_mulai} - ${data.jam_selesai}
        `;

        toast.style.display = 'block';

        setTimeout(() => {
          toast.style.display = 'none';
        }, 4000);

      }

    });
}, 5000);


</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctx = document.getElementById('inventarisChart');

if(ctx){

new Chart(ctx,{

type:'bar',

data:{

labels:['Total','Baik','Rusak'],

datasets:[{

label:'Jumlah Barang',

data:[
<?= $totalBarang ?>,
<?= $totalBaik ?>,
<?= $totalRusak ?>
],

borderWidth:1

}]

},

options:{
responsive:true,
plugins:{
legend:{
display:false
}
}
}

});

}

const pie=document.getElementById('pieChart');

if(pie){

new Chart(pie,{

type:'doughnut',

data:{

labels:['Baik','Rusak'],

datasets:[{

data:[
<?= $totalBaik ?>,
<?= $totalRusak ?>
]

}]

},

options:{
responsive:true
}

});

}

</script>

<audio id="notifSound">
  <source src="assets/sound/notif.mp3" type="audio/mpeg">
</audio>

</body>
</html>