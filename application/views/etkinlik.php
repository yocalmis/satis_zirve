<?php error_reporting(0);
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// error_reporting(0);
?>


<?php $this->load->view('header.php');?>

<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>




<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='<?php echo base_url(); ?>assets/calendar/packages/core/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/calendar/packages/daygrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/calendar/packages/timegrid/main.css' rel='stylesheet' />
<link href='<?php echo base_url(); ?>assets/calendar//packages/list/main.css' rel='stylesheet' />
<script src='<?php echo base_url(); ?>assets/calendar/packages/core/main.js'></script>
<script src='<?php echo base_url(); ?>assets/calendar/packages/interaction/main.js'></script>
<script src='<?php echo base_url(); ?>assets/calendar/packages/daygrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/calendar/packages/timegrid/main.js'></script>
<script src='<?php echo base_url(); ?>assets/calendar/packages/list/main.js'></script>
<script src='<?php echo base_url(); ?>assets/calendar/packages/core/locales-all.js'></script>
<script>

      Element.prototype.remove = function() {
      this.parentElement.removeChild(this);
    }
    NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
      for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
          this[i].parentElement.removeChild(this[i]);
        }
      }
    }

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');



    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      defaultDate: '<?php echo date("Y-m-d"); ?>',
    locale: 'tr',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {
        var title = prompt('Etkinlik Açıklaması:');
        if (title) {
         calendar.addEvent({
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
          })

    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>yonetim/etkinlikal",
        data: {
            title: title,
            start: arg.start,
            end: arg.end,
            allDay: arg.allDay
        },
        success: function(res){
          //var res = JSON.parse(res);
          alert(res);

        }
    })


        }
        calendar.unselect()
      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events
    events:<?php echo $json; ?>
    /*  [  {
          title: 'All Day Event',
          start: '2019-08-01'
        },
        {
          title: 'Long Event',
          start: '2019-08-07',
          end: '2019-08-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2019-08-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2019-08-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2019-08-11',
          end: '2019-08-13'
        },
        {
          title: 'Meeting',
          start: '2019-08-12T10:30:00',
          end: '2019-08-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2019-08-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2019-08-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2019-08-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2019-08-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2019-08-13 07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2019-08-28'
        } ]*/

,eventRender: function(info) {
          var closeSpan = document.createElement('span');
          closeSpan.className = 'fc-event__delete';
          closeSpan.innerText = 'x';
          closeSpan.onclick = function(e) {
           // console.log(info.event.id)
           info.el.remove();


    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>yonetim/etkinliksil",
        data: {
            id: info.event.id
        },
        success: function(res){
          //var res = JSON.parse(res);
          alert(res);

        }
    })

          };
          info.el.appendChild(closeSpan);
        },


    });

    calendar.render();




  });

</script>
<style>


#calendar
{

background-color: #FFFFFF;
}

    .fc-day-grid-event {
      padding: 0 11px 0 1px;
    }
    .fc-event__delete {
      position: absolute;
      right: 2px;
      top: 0;
      z-index: 2;

    }

</style>
</head>
<body>

  <div id='calendar'></div>

</body>
</html>








  <?php $this->load->view('footer.php');?>



