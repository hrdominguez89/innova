<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($this->session->flashdata('message')):?>
    <div class="message-error" data-message='<?php echo $this->session->flashdata('message');?>'></div>
<?php endif;?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>home">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst(mb_strtolower($subtitle, 'UTF-8'));?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-right">
                <a href="<?php echo base_url().'categories/insert';?>" class="btn btn-primary"><i class="fas fa-plus"></i>&nbspNueva Categoría</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-primary">
                    <h4 class="card-title"><?php echo $title;?></h4>
                    <p class="card-category"><?php echo ucfirst(mb_strtolower($subtitle, 'UTF-8'));?></p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table">
                            <tbody>
                                <?php foreach($categories as $category):;?>
                                <tr>
                                    <td><?php echo $category->descripcion;?></td>
                                    <td class="td-actions text-center">
                                        <a style="font-size:20px" title="Editar" href="<?php echo base_url().'categories/edit/'.$category->id;?>" class="text-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="td-actions text-center">
                                        <div onclick="btnOnOffCategory(this)" data-target="<?php echo $category->id;?>" data-status=<?php echo $category->activo;?> style="font-size:20px" title="<?php echo $category->activo? 'Desactivar categoría':'Activar categoría';?>"  class="text-<?php echo $category->activo? 'success':'muted';?> cursor onOffCategory">
                                            <i class="fas fa-toggle-<?php echo $category->activo? 'on':'off';?>"></i>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <?php echo $this->pagination->create_links();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>