 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <div class="col-md-11">
            <div class="container-fluid">
                <h1 class="main_headng">Manage Products</h1>
                <?php if ($this->session->flashdata('message') !== NULL) { ?>

                <div class="alert alert-<?php echo $this->session->flashdata('message')['0'] == 1 ? 'success' : 'danger'; ?> alert-dismissible">

                <?php echo $this->session->flashdata('message')['1']; ?>


                </div>
                
            <?php } ?>
                <ul class="nav mt-5">
                    <li class="nav-item">
                        <a class="nav-link1 " href="<?php echo base_url('seller/product?cid=0') ?>">All</a>
                    </li>
                    <?php if(!empty($categories)){
                            foreach ($categories as $key => $value) 
                            {?>
                            <li class="nav-item">
                                <a class="nav-link1" href="<?php echo base_url('seller/product?cid='.$value['id']) ?>"><?php echo $value['l1_category']; ?></a>
                            </li>
                      <?php } } ?>
                      
                </ul>
                <ul class="nav" style="float:right;">
                       <li class="nav-item" >
                        <a href="<?php echo base_url('seller/product/add_product'); ?>" class="nav-link1">Add</a>
                    </li>
                </ul>
                <table class="table mt-5 table-striped">
                    <thead class="mb-4">
                        <tr>
                            <th scope="col" class="table_head">ID</th>
                            <th scope="col" class="table_head">Name</th>
                            <th scope="col" class="table_head">MRP</th>
                            <th scope="col" class="table_head">Discount</th>
                            <th scope="col" class="table_head">Sellinf Price</th>
                            <th scope="col" class="table_head">Stock</th>
                            <th scope="col" class="table_head">Qunatity in Stock</th>
                            <th scope="col" class="table_head">Image</th>
                            <th scope="col" class="table_head">Action</th>
                        </tr>
                    </thead>
                    <tbody class="table_body ">
                        <?php if(!empty($list)){
                              foreach ($list as $key => $value) {
                         ?>
                        <tr class="table_tr table-wid">
                            <td><?php $key+1; ?></td>
                            <td><?php echo $value['product_name'] ?></td>
                            <td>Rs. <?php echo $value['price_for_seller'] ?></td>
                            <td>Rs. <?php echo $value['discount_percent'] ?></td>
                            <td>Rs. <?php echo $value['price'] ?></td>
                            <td><?php if($value['stock'] >0){ echo "In"; }else{ echo "Out"; }?></td>
                            <td><?php echo $value['stock'] ?></td>
                            <td><img width="100px" height="100px" src="<?php echo $value['product_image'] ?>" /></td>
                            <td><a href="<?php echo base_url('seller/product/edit_product/'.$value['id']) ?>"><i class="fa fa-edit"></i></a></td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
