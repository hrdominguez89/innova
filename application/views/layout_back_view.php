<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es" class="perfect-scrollbar-on">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Innova 4.0">
  <meta name="author" content="Innova 4.0">
  <link rel="icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!-- Si $data['recaptcha'] = true muestro script de recaptcha-->
  <?php if (@$recaptcha) :; ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->data_captcha_google->siteKey; ?>&hl=es-419"></script>
  <?php endif; ?>

  <title><?php echo isset($title) ? $title . ' | RIA' : 'RIA'; ?></title>

  <!-- Cargo los css cargados desde el controlador -->


  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <script src="https://use.fontawesome.com/releases/v5.6.3/js/all.js"></script>
  <!-- CSS Files -->
  <link href="<?php echo base_url(); ?>assets/material/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/material/css/chartist.min.css?v=2.1.2" rel="stylesheet" />

  <!-- CROPPER File -->
  <link rel="stylesheet" href="<?php echo base_url() . 'assets/cropperjs/cropper.min.css'; ?>" integrity="sha512-NCJ1O5tCMq4DK670CblvRiob3bb5PAxJ7MALAz2cV40T9RgNMrJSAwJKy0oz20Wu7TDn9Z2WnveirOeHmpaIlA==" crossorigin="anonymous" />
  <link href="<?php echo base_url() . 'assets/css/perfect-scrollbar.css'; ?>" rel="stylesheet">

  <!-- CHOSEN File -->
  <link href='<?php echo base_url() . 'assets/chosen/chosen.min.css'; ?>' rel='stylesheet' type='text/css'>


  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/styles.css">
  <?php
  if (isset($files_css)) {
    foreach ($files_css as $file) {
      echo '<link href="' . base_url() . 'assets/css/' . $file . '?v=' . rand() . '" rel="stylesheet" type="text/css" />';
    }
  }
  ?>
</head>

<body class="sidebar-mini">
  <?php echo $this->load->view('notificaciones/notificaciones_modal_view');; ?>
  <div class="wrapper">
    <!-- Menu -->
    <?php
    switch ($this->session->userdata('user_data')->rol_id) {
      case ROL_STARTUP:
        $this->load->view('menus/menu_startups_view');
        break;
      case ROL_EMPRESA:
        $this->load->view('menus/menu_empresas_view');
        break;
      case ROL_PARTNER:
        $this->load->view('menus/menu_partners_view');
        break;
      case ROL_VALIDADOR:
        $this->load->view('menus/menu_admin_gcba_view');
        break;
      case ROL_ADMIN_PLATAFORMA:
        $this->load->view('menus/menu_admin_plataforma_view');
        break;
    }
    ?>
    <!-- FIN MENU  -->

    <div class="main-panel">
      <!-- HEADER -->
      <?php $this->load->view('header_back_view'); ?>
      <!-- FIN HEADER -->

      <!-- SECTIONS -->
      <?php $this->load->view($sections_view); ?>
      <!-- END SECTIONS -->

      <!-- FOOTER -->
      <?php $this->load->view('footer_back_view'); ?>
      <!-- END FOOTER -->

    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="<?php echo base_url(); ?>assets/material/js/core/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/material/js/core/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/material/js/core/bootstrap-material-design.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Plugin for the momentJs  -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/moment.min.js"></script>
  <!--  Plugin for Sweet Alert -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/sweetalert2.js"></script>
  <!-- Forms Validations Plugin -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/jquery.validate.min.js"></script>
  <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/jquery.bootstrap-wizard.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <!-- <script src="<?php echo base_url(); ?>assets/material/js/plugins/bootstrap-selectpicker.js"></script> -->
  <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/jquery.dataTables.min.js"></script>
  <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/bootstrap-tagsinput.js"></script>
  <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/jasny-bootstrap.min.js"></script>
  <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/fullcalendar.min.js"></script>
  <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
  <!-- <script src="<?php echo base_url(); ?>assets/material/js/plugins/jquery-jvectormap.js"></script> -->
  <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/nouislider.min.js"></script>
  <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <!-- Library for adding dinamically elements -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/arrive.min.js"></script>
  <!--  Google Maps Plugin    -->
  <?php if (@$google_maps) :; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $this->google_maps->api_key; ?>"></script>
  <?php endif; ?>
  <!-- Chartist JS -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url(); ?>assets/material/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url(); ?>assets/material/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <!-- CROPPER File -->
  <script src="<?php echo base_url() . 'assets/cropperjs/cropper.min.js'; ?>" integrity="sha512-FHa4dxvEkSR0LOFH/iFH0iSqlYHf/iTwLc5Ws/1Su1W90X0qnxFxciJimoue/zyOA/+Qz/XQmmKqjbubAAzpkA==" crossorigin="anonymous"></script>
  <!-- CHOSEN File -->
  <script src='<?php echo base_url() . 'assets/chosen/chosen.jquery.min.js'; ?>' type='text/javascript'></script>

  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
        //selects chosen
        if ($(".select_chosen").length != 0) {
          $('select').chosen({
            width: '100%',
            disable_search: true,
            no_results_text: "No se encuentra coincidencias con",
          });
        }
      });
    });
  </script>
  <!-- <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

      md.initVectorMap();

    });
  </script> -->
  <script>
    const BASE_URL = '<?php echo base_url(); ?>';
    //Script param mostrar los mensajes de error.
    window.addEventListener('load', () => {
      const messageError = document.getElementsByClassName('message-error');
      if (messageError[0]) {
        swal(JSON.parse(messageError[0].dataset.message));
      }
      <?php if ($this->session->flashdata('message_alert')) :; ?>
        swal(<?php echo $this->session->flashdata('message_alert'); ?>);
      <?php endif; ?>
    });
  </script>
  <script src="<?php echo base_url(); ?>assets/js/notificaciones/notificaciones.js?v=<?php echo rand(); ?>"></script>
  <!-- CONDICIONAL PARA CARGAR LOS SCRIPT DESDE EL CONTROLLER -->
  <?php if (isset($files_js)) {
    foreach ($files_js as $file_js) {
      # code...
      echo '<script src="' . base_url() . 'assets/js/' . $file_js . '?v=' . rand() . '"></script>';
    }
  } ?>
</body>

</html>