    <div class="container regionblock p-0">
        <div class="row">
            <div class="col">
                <h5 class="fw-bold">Edit Brand</h5>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col ">
                <div class="card">
                    <div class="card-body position-relative">
                        <form class="row" method="post" enctype="multipart/form-data"
                            action="<?php echo admin_url('admin-ajax.php'); ?>">
                            <input type="hidden" name="action" value="update_brand">
                            <input type="hidden" name="bid" value="<?php echo $result[$i]->bid; ?>">
                            <div class="col-sm-12 col-md-12 col-lg-4 p-0 m-0">

                                <?php if (empty($result[$i]->icon)) { ?>
                                <div class="banner image_area d-flex">
                                    <label for="Brandbanner<?php echo $result[$i]->bid; ?>">
                                        <div class="imgwrapp d-flex align-items-center" id="letswrap"
                                            style="height: 100%; width:100%; overflow: hidden">
                                            <img src="" alt="" id="theBrandBanner<?php echo $result[$i]->bid; ?>"
                                                style="max-width: 100%; height: auto ">
                                        </div>
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <div class="text">Click to Change Brand Logo</div>
                                        </div>
                                        <input type="file" name="carBrand[]" class="form-control"
                                            id="Brandbanner<?php echo $result[$i]->bid; ?>" style="display:none"
                                            onchange="readURL(this);"
                                            data-target="theBrandBanner<?php echo $result[$i]->bid; ?>">
                                    </label>
                                </div>
                                <?php } else { ?>
                                <div class="banner image_areaRegion d-flex align-items-center justify-content-center">
                                    <label for="for<?php echo $result[$i]->bid; ?>">
                                        <div class="imgwrapp d-flex align-items-center"
                                            style="height: 100%; width:100%; overflow: hidden">
                                            <img src="<?php echo bloginfo('template_directory') . "/img/brands/" . $result[$i]->icon; ?>"
                                                alt="" id="maindesbanner<?php echo $result[$i]->bid; ?>"
                                                style="max-width: 100%; height: auto ">
                                        </div>
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <div class="text">Click to Change Profile Image</div>
                                        </div>
                                        <input id="for<?php echo $result[$i]->bid; ?>" style="display:none" type="file"
                                            name="carBrand[]" class="form-control" onchange="readURL(this);"
                                            data-target="maindesbanner<?php echo $result[$i]->bid; ?>">
                                    </label>
                                </div>
                                <?php } ?>


                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-8 pe-0">
                                <div class="picwrap">
                                    <label for="destinationName" class="form-label fw-bold">Brand
                                        Name:</label>
                                    <input name="destinationName" type="text" class="wrppic form-control mb-5"
                                        value="<?php echo $result[$i]->name; ?>" />
                                </div>

                                <div>
                                    <button class="btn btn-warning floatbtnEdit" type="submit">Update</button>
                                </div>
                            </div>
                        </form>

                        <form method="post" enctype="multipart/form-data" id="form<?php echo $result[$i]->bid; ?>"
                            action="<?php echo admin_url('admin-ajax.php'); ?>">
                            <input type="hidden" id="<?php echo $result[$i]->bid; ?>" name="action"
                                value="delete_brand">
                            <input type="hidden" name="bid" value="<?php echo $result[$i]->bid; ?>">
                            <button type="submit" class="btn btn-danger dltSubServBtn floatbtn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>