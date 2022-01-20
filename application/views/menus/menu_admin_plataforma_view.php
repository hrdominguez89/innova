
<style>
  
  </style>
  <div class="sidebar" data-color="purple" data-background-color="black" data-image="<?php echo base_url(); ?>assets/img/sidebar-3.jpg">
    <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
  
          Tip 2: you can also add an image using data-image tag
      -->
    <?php $this->load->view('menus/logo_menu_sidebar_view');?>
    <div class="sidebar-wrapper">
      <!-- Menu usuario -->
      <?php $this->load->view('menus/notificaciones_sidebar_menu_view'); ?>
  
      <ul class="nav">
  
        <!-- menu home -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'home' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>home">
            <i class="material-icons">home</i>
            <p> Home </p>
          </a>
        </li>
  
        <!-- menu desafios -->

        <!-- menu postulaciones -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'desafios' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>desafios">
            <i class="material-icons">ballot</i>
            <p>
            Desafíos
            </p>
          </a>
        </li>

        <!-- menu postulaciones -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'postulados' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>postulados">
            <i class="material-icons">emoji_people</i>
            <p>
              Postulaciones
            </p>
          </a>
        </li>

        <!-- menu Startups -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'startups' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>startups">
            <i class="material-icons">rocket_launch</i>
            <p>
              Startups
            </p>
          </a>
        </li>

        <!-- menu empresas -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'empresas' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>empresas">
            <i class="material-icons">apartment</i>
            <p>
              Empresas
            </p>
          </a>
        </li>

        <!-- menu partners -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'partners' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>partners">
            <i class="material-icons">groups</i>
            <p>
              Partners
            </p>
          </a>
        </li>

        <!-- menu usuarios -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'usuarios' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>usuarios">
            <i class="material-icons">people_outline</i>
            <p>
              Usuarios
            </p>
          </a>
        </li>

        
        <!-- menu categorias -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'categories' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>categories">
            <i class="material-icons">category</i>
            <p>
              Categorías
            </p>
          </a>
        </li>
        
        <!-- menu configuracion de la plataforma -->
        <li class="nav-item <?php echo $this->uri->segment(URI_SEGMENT) == 'configuraciones' ? 'active' : ''; ?>">
          <a class="nav-link" href="<?php echo base_url(); ?>configuraciones">
            <i class="material-icons">settings_suggest</i>
            <p>
              Configuraciones
            </p>
          </a>
        </li>


      </ul>
    </div>
  </div>