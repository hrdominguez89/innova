<nav class="navbar navbar-expand-lg bg-dark my-0">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="<?php echo index_page();?>">Innova 4.0</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navbarDropdown" aria-expanded="false" aria-label="Toggle navigation" data-target="#navbarDropdown">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo index_page();?>">Inicio <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item <?php echo strtolower($this->uri->segment(1))=='startups'? 'active':'';?>">
                    <a class="nav-link" href="<?php echo base_url().'startups';?>">Startup</a>
                </li>
                <li class="nav-item <?php echo strtolower($this->uri->segment(1))=='partners'? 'active':'';?>">
                    <a class="nav-link" href="<?php echo base_url().'partners';?>">Partners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo index_page().'blog';?>">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo index_page().'contacto';?>">Contacto</a>
                </li>
                <li class="nav-item <?php echo $this->uri->segment(2)=='login'? 'active':'';?>">
                    <a class="nav-link" href="<?php echo base_url().'auth/login';?>">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>