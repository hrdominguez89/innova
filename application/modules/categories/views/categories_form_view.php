<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>home">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>categories">Listado de categorías</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst(mb_strtolower($subtitle, 'UTF-8'));?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url().'categories/';echo $this->uri->segment(2)=='edit'? 'edit/'.$this->uri->segment(3):'insert';?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">category</i>
                            </div>
                            <h4 class="card-title"><?php echo $subtitle;?></h4>
                        </div>
                        <div class="card-body ">
                            <div class="form-group bmd-form-group">
                                <label for="category_name" class="bmd-label-floating">Nombre de la categoría</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo set_value('category_name',@$category->descripcion);?>" required>
                                <?php echo form_error('category_name');?>
                            </div>
                        </div>
                        <div class="card-footer justify-content-end">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <a href="<?php echo base_url().'categories';?>" class="btn btn-default">Cancelar</a>
                                    <button type="submit" class="btn btn-fill btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>