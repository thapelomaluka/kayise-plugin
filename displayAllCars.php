<div class="accordion" id="carAccord">
    <!-- Displaying the sub destinations -->

    <?php $carquery = 'SELECT * FROM `wp_cars` WHERE `brand_id` = ' . $result[$i]->bid;

    $cars = $wpdb->get_results($carquery);
    foreach ($cars as $key => $car) : ?>
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?php echo strtolower(str_replace(' ', '-', $car->name)); ?>">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse<?php echo strtolower(str_replace(' ', '-', $car->name)); ?>"
                aria-expanded="true"
                aria-controls="collapse<?php echo strtolower(str_replace(' ', '-', $car->name)); ?>">
                <?php echo $car->name; ?>
            </button>
        </h2>
        <div id="collapse<?php echo strtolower(str_replace(' ', '-', $car->name)); ?>"
            class="accordion-collapse collapse"
            aria-labelledby="heading<?php echo strtolower(str_replace(' ', '-', $car->name)); ?>"
            data-bs-parent="#carAccord">
            <div class="accordion-body">
                <div class="container position-relative m-0 p-0">
                    <form class="m-0 row position-relative" method="post" enctype="multipart/form-data"
                        action="<?php echo admin_url('admin-ajax.php'); ?>">
                        <input type="hidden" name="action" value="update_car">
                        <input type="hidden" name="bid" value="<?php echo $car->cid; ?>">
                        <div class="col-sm-12 col-md-6 m-0 p-0">
                            <?php if (empty($car->banner)) { ?>
                            <div class="banner image_area d-flex">
                                <label for="Dabanner<?php echo $car->cid; ?>">
                                    <div class="imgwrapp d-flex align-items-center"
                                        id="letswrap<?php echo $car->cid; ?>"
                                        style="height: 100%; width:100%; overflow: hidden">
                                        <img src="<?php echo bloginfo('template_directory') . "/img/cars/" . $car->pictures; ?>"
                                            alt="" id="theBan<?php echo $car->cid; ?>"
                                            style="max-width: 100%; height: auto ">
                                    </div>
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text">Click to Change Profile Image</div>
                                    </div>
                                    <input id="Dabanner<?php echo $car->cid; ?>" style="display:none" type="file"
                                        name="carBrand[]" class="form-control" onchange="readURL(this);"
                                        data-target="theBan<?php echo $car->cid; ?>">
                                </label>
                            </div>


                            <?php } else { ?>
                            <div class="banner image_area d-flex">
                                <label for="for<?php echo $car->cid; ?>">
                                    <div class="imgwrapp d-flex align-items-center"
                                        id="letswrap<?php echo $car->cid; ?>"
                                        style="height: 100%; width:100%; overflow: hidden">
                                        <img src="../wp-content/themes/AweAfrica/img/cars_banner/<?php echo $car->banner; ?>"
                                            alt="" id="subdesbanner<?php echo $car->cid; ?>"
                                            style="max-width: 100%; height: auto ">
                                    </div>
                                    <div class="overlay d-flex align-items-center justify-content-center">
                                        <div class="text">Click to Change Profile Image</div>
                                    </div>
                                    <input id="for<?php echo $car->cid; ?>" style="display:none" type="file"
                                        name="carBrand[]" class="form-control" onchange="readURL(this);"
                                        data-target="subdesbanner<?php echo $car->cid; ?>">
                                </label>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-sm-12 col-md-6 m-0">
                            <div class="picwrap">
                                <label for="namecar" class="form-label fw-bold">Destination
                                    Name:</label>
                                <input name="namecar" type="text" class="wrppic form-control"
                                    value="<?php echo $car->name; ?>" />
                            </div>
                            <div class="contwrp mb-5">
                                <div class="wped">
                                    <label for="destinationDesc" class="form-label fw-bold">Destination
                                        Description:</label>
                                    <textarea name="destinationDesc" class="form-control" id="destinationDesc"
                                        cols="30"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-warning floatbtnEdit2" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col">
                            <form method="post" enctype="multipart/form-data" id="form<?php echo $car->cid; ?>"
                                action="<?php echo admin_url('admin-ajax.php'); ?>">
                                <input type="hidden" id="<?php echo $car->cid; ?>" name="action" value="delete_car">
                                <input type="hidden" name="bid" value="<?php echo $car->cid; ?>">
                                <button type="submit" class="btn btn-danger dltSubServBtn floatbtn2">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>