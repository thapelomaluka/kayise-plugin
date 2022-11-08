 <form method="post" class="form-floating" enctype="multipart/form-data"
     action="<?php echo admin_url('admin-ajax.php'); ?>">
     <input type="hidden" name="action" value="create_car">
     <input type="hidden" name="bid" value="<?php echo $result[$i]->bid; ?>">

     <div class="container card mb-3">
         <ul class="list-group list-group-flush" id="subfield<?php echo $result[$i]->bid; ?>">
             <li class="list-group-item">
                 <div class="row">
                     <div class="col-sm-12 col-md-12 col-lg-5">

                         <div class="banner image_area d-flex">
                             <label for="Dabanner">
                                 <div class="imgwrapp d-flex align-items-center" id="letswrap"
                                     style="height: 100%; width:100%; overflow: hidden">
                                     <img src="" alt="" id="theBan" style="max-width: 100%; height: auto ">
                                 </div>
                                 <div class="overlay d-flex align-items-center justify-content-center">
                                     <div class="text">Click to Change Car Image</div>
                                 </div>
                                 <input type="file" name="carBrand[]" class="form-control" id="Dabanner"
                                     style="display:none" onchange="readURL(this);" data-target="theBan">

                             </label>
                         </div>
                     </div>
                     <div class="col-sm-12 col-md-12 col-lg-7">

                       
                         <label for="carMake" class="form-label fw-bold">Make:</label>
                         <input name="car_name[]" type="text" class="form-control" value="<?php echo $result[$i]->name; ?>" />
                         <div class="errmsg" id="car_nameError"></div>
                     
                         <label for="carModel" class="form-label fw-bold">Model:</label>               
                         <input type="text" name="car_model[]" placeholder="Model" class="form-control" />
                         <div class="errmsg" id="car_modelError"></div>
                     
                         <label for="carYear" class="form-label fw-bold">Year:</label>
                         <input type="text" name="car_year[]" placeholder="Year" class="form-control" />
                         <div class="errmsg" id="car_yearError"></div>
                     
                         <label for="carMileage" class="form-label fw-bold">Mileage:</label>
                         <input type="text" name="car_mileage[]" placeholder="Mileage" class="form-control" />
                         <div class="errmsg" id="car_mileageError"></div>
                     
                         <label for="carTransmission" class="form-label fw-bold">Transmission:</label>
                         <input type="text" name="car_transmission[]" placeholder="Transmission" class="form-control" />
                         <div class="errmsg" id="car_transmissionError"></div>
                     
                         <label for="carBodytype" class="form-label fw-bold">Body Type:</label>
                         <input type="text" name="car_bodytype[]" placeholder="Body Type" class="form-control" />
                         <div class="errmsg" id="car_bodytypeError"></div>
                     
                         <label for="carFueltype" class="form-label fw-bold">Fuel Type:</label>
                         <input type="text" name="car_fueltype[]" placeholder="Fuel Type" class="form-control" />
                         <div class="errmsg" id="car_fueltypeError"></div>
                     
                         <label for="carPrice" class="form-label fw-bold">Price:</label>
                         <input type="text" name="car_price[]" placeholder="Price" class="form-control" />
                         <div class="errmsg" id="car_priceError"></div>

                     </div>
                 </div>
             </li>
     </div>

     <div class="container mb-4">
         <div class="row">
             <div class="col">
                 <div class="d-flex align-items-center justify-content-end">
                     <button class="btn btn-success me-3" type="submit">Save</button>
                     <button type="button" data-row="<?php echo $result[$i]->bid; ?>"
                         class="btn btn-primary addcarfield"><i class="fa fa-plus" aria-hidden="true"></i>
                         More</button>
                 </div>
             </div>
         </div>
     </div>
 </form>