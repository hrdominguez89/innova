<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content mb-5">
    <div class="container-fluid">
        <div class="row">
            <?php if($this->session->userdata('user_data')):;?>
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>home">Home</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <?php endif;?>
            <div class="col-md-12 mb-5">
                <h3>La página indicada no se encuentra. <i class="fas fa-exclamation-triangle"></i></h3>
            </div>
        </div>
    </div>
</div>