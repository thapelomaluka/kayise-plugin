<?php
/*
Plugin name: KAYISE IT Plugin
URI: not defined
Description: A simple plugin to add extra info to posts. Author: thando Hlophe Version: 0.5 */
ob_start();
if (!function_exists('extra_post_info')) {
    function extra_post_info($content)
    {
        $extra_info = 'EXTRA INFO';

        return $content;
    }

    add_filter('the_content', 'extra_post_info');
    add_action('admin_menu', 'extra_post_info_menu');

    function extra_post_info_menu()
    {
        $page_title = 'Tenhle Auto';
        $menu_title = 'Tenhle Auto';
        $capability = 'manage_options';
        $menu_slug = 'tenhle-cars';
        $function = 'carbrans_dashboard';
        $icon_url = 'dashicons-media-code';
        $position = 4;
        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
        add_action('admin_init', 'update_extra_post_info');
    }
}

function asasasew()
{
    wp_enqueue_style('kayisestyle', plugins_url('kayise-plugin/css/kayisestyle.css'), __FILE__);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', [], 1, 'all');
}
add_action('admin_print_styles', 'asasasew');

function scriptsJS()
{
    wp_enqueue_script('kayisescript', plugins_url('kayise-plugin/js/kayisescript.js'), __FILE__);
    wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js', [], 1, 1, 1);
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', [], 1, 1, 1);
}
add_action('admin_print_scripts', 'scriptsJS');

if (!function_exists('update_extra_post_info')) {
    function update_extra_post_info()
    {
        register_setting('extra-post-info-settings', 'extra_post_info');
    }
}

function carbrans_dashboard()
{
?>

<h1>Tenhle Auto</h1>
<p>Lets add our cars and their description</p>

<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="fw-bold">Add New Brand</h2>
            <form method="post" enctype="multipart/form-data" action="<?php echo admin_url('admin-ajax.php'); ?>">
                <?php submit_button(); ?>
                <table class="table" id="serviceTable">
                    <tr>
                        <td>
                            <input type="hidden" name="action" value="create_brand">
                            <input type="file" name="carBrand[]" class="service_icon form-control">
                        </td>
                        <td>

                            <input type="text" name="brand[]" placeholder="Enter Brand Name"
                                class="form-control name_list" />
                        </td>
                        <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php
    require 'accordionbody.php';
}
/* Delete Service PHP Function */
add_action('wp_ajax_delete_brand', 'delete_brand');

function delete_brand()
{
    global $wpdb;
    $servId = $_POST['bid'];
    $resp = '';
    $message = '';

    $res = $wpdb->get_row($wpdb->prepare('SELECT bid, name, icon FROM `wp_brands` WHERE `bid` = %d', (int) $servId));
    $cars = $wpdb->get_results($wpdb->prepare('SELECT bid, name FROM `wp_cars` WHERE `cid` = %d', (int) $servId));

    if ($res) {
        if (deleteIcon($res->icon)) {
            /* 11111111 */
            $post = get_page_by_title($res->name, OBJECT, 'page');

            if (delCar($cars)) {
                if ($wpdb->query($wpdb->prepare("DELETE FROM `wp_brands` WHERE `bid` = '%d'", $servId))) {
                    if (wp_delete_post($post->ID)) {
                        $message = 'Deleted the service';
                    }
                } else {
                    $message = 'Not deleted';
                }
            } else {
                echo "asdadasd";
            }
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
/* End */

/* Delete carice PHP Function */
add_action('wp_ajax_delete_car', 'delete_car');

function delete_car()
{
    global $wpdb;
    $servId = $_POST['cid'];
    $resp = '';
    $message = '';

    $res = $wpdb->get_row($wpdb->prepare('SELECT * FROM `wp_brands` WHERE `cid` = %d', (int) $servId));
    $post = get_page_by_title($res->name, OBJECT, 'post');

    if ($res) {
        (!empty($res->icon)) ? deleteIcon($res->icon) : ' ';

        if ($wpdb->query($wpdb->prepare("DELETE FROM `wp_cars` WHERE `brand_id` = '%d'", $servId))) {
            if (wp_delete_post($post->ID)) {
                $message = 'Deleted car';
            }
        } else {
            $message = 'Not deleted';
        }
    }
    wp_reset_postdata();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
/* End */

add_action('wp_ajax_create_brand', 'create_brand');

function create_brand()
{
    global $wpdb;
    $error = [];
    foreach ($_POST['brand'] as $key => $service) {
        $brand = "";
        $target_file = "";
        $icon = "";
        $updateArr = [];
        $data = [];
        $format = [];
        $upstat = [];

        $result = $wpdb->get_row("SELECT * FROM wp_brands WHERE name ='$service'");

        if (isset($_POST['brand'][$key])) {
            $brand = esc_sql($_POST['brand'][$key]);
            array_push($updateArr, ['name' => $brand]);
            array_push($format, '%s');
        }

        if ($_FILES['carBrand']['name'][$key] !== null && !empty($_FILES['carBrand']['name'][$key])) {
            if (isset($_FILES['carBrand']['name'][$key])) {
                $target_file = $_FILES['carBrand']['name'][$key];
                $icon = $brand . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_FILES['carBrand']['name']) && $_FILES['carBrand']['name'] !== $icon) {
                    array_push($updateArr, ['icon' => $icon]);
                    array_push($format, '%s');
                    $upstat = uploadBrand($pid = null, $_FILES, $brand);
                }
            }
        }


        if (count($error) == 0) {


            $table_name = $wpdb->prefix . 'brands'; //try not using Uppercase letters or blank spaces when naming db tables

            $wpdb->insert($table_name, array_reduce($updateArr, 'array_merge', []), $format);
            $pid = $wpdb->insert_id;

            createCat($brand, str_replace(' ', '-', $brand));
            dynaPage($brand);
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function create_car()
{
    global $wpdb;
    

    foreach ($_POST['car_name'] as $key => $service) {
        
        $result = $wpdb->get_row("SELECT * FROM wp_cars WHERE 'name' = '$service' ");
        $brand = "";
        $bid = "";
        $description = "";
        $banner = '';

        $name = "";
        $model = "";
        $year = "";
        $price = "";
        $brand_id = "";
        $mileage = "";
        $type = "";
        $pictures = "";
        $transmission = "";
        $fuel_type = "";
        $data=[];
        $error=[];


        $name = (isset($_POST['car_name'])) ? esc_sql($_POST['car_name'][$key]) : array_push($error, ['car_Error' => 'Empty Car Name']);
        $model = (isset($_POST['car_model'])) ? esc_sql($_POST['car_model'][$key]) : array_push($error, ['car_modelError' => 'Empty Car model']);
        $year = (isset($_POST['car_year'])) ? esc_sql($_POST['car_year'][$key]) : array_push($error, ['car_yearError' => 'Empty Car Year']);
        $price = (isset($_POST['car_price'])) ? esc_sql($_POST['car_price'][$key]) : array_push($error, ['car_priceError' => 'Empty Car Price']);
        $mileage = (isset($_POST['car_mileage'])) ? esc_sql($_POST['car_mileage'][$key]) : array_push($error, ['car_mileageError' => 'Empty Car Mileage']);
        $type = (isset($_POST['car_bodytype'])) ? esc_sql($_POST['car_bodytype'][$key]) : array_push($error, ['car_bodytypeError' => 'Empty Car Body Type']);
        $transmission = (isset($_POST['car_transmission'])) ? esc_sql($_POST['car_transmission'][$key]) : array_push($error, ['car_transmissionError' => 'Empty Car Transmission']);
        $fuel_type = (isset($_POST['car_fueltype'])) ? esc_sql($_POST['car_fueltype'][$key]) : array_push($error, ['car_fueltypeError' => 'Empty Car Fuel Type']);



        if ($_FILES['carBrand']['name'][$key] !== null && !empty($_FILES['carBrand']['name'][$key])) {
            if (isset($_FILES['carBrand']['name'][$key])) {
                $target_file = $_FILES['carBrand']['name'][$key];
                $pictures = $brand . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_FILES['carBrand']['name']) && $_FILES['carBrand']['name'] !== $pictures) {
                    array_push($updateArr, ['pictures' => $pictures]);
                    array_push($format, '%s');

                    $upstat = uploadCarImage($bid, $_FILES, $brand);
                }
            }
        }

        $brand_id = intval(esc_sql($_POST['bid']));
        $banner = '';

        $target_file = $_FILES['carBrand']['name'][$key];
        $banner = $brand . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($result) {
            $error['exists'] = 'service exists ';
        }
        if (count($error) == 0) {
            /*Create trat charge ttttttt*/
            $table_name = $wpdb->prefix . 'cars'; //try not using Uppercase letters or blank spaces when naming db tables
            $data = [
                'name' => $name,
                'model' => $model,
                'year' => $year,
                'price' => $price,
                'mileage' => $mileage,
                'pictures' => $pictures,
                'type' => $type,
                'transmission' => $transmission,
                'fuel_type' => $fuel_type,
                'pictures' => $pictures,
                'brand_id' => $brand_id,
                
            ];
            $format = ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d'];

            $wpdb->insert($table_name, $data, $format);
            $pid = $wpdb->insert_id;
            
            $sname = $wpdb->get_results("SELECT name FROM wp_brands WHERE bid = $bid");
            $sname = $sname[0]->name;
            dynaPost($brand, $description, $sname);
        } else {
            wp_send_json_error($error);
        }
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
add_action('wp_ajax_create_car', 'create_car');

function createCat($catName, $catSlug)
{
    //create the main category
    wp_insert_term(
        /* the name of the category */
        $catName,
        /* the taxonomy, which in this case if category (don't change) */
        'category',
        [
            /* what to use in the url for term archive */
            'slug' => $catSlug,
            /* link with main category. In the case, become a child of the "Category A" parent   */
            /* 'parent' => term_exists('Destinations', 'category')['term_id'], */
        ]
    );
}

function dynaPage($post_title)
{
    global $user_ID;
    $new_post = [
        'post_title' => $post_title,
        'post_content' => '',
        'post_status' => 'publish',
        'post_date' => date('Y-m-d H:i:s'),
        'post_author' => $user_ID,
        'post_type' => 'page',
        'post_parent' => 10,
        'page_template' => 'destinations-locations.php',
    ];
    $post_id = wp_insert_post($new_post);
}

function dynaPost($post_title, $post_content, $post_category)
{
    $cat_id = get_cat_ID($post_category);
    global $user_ID;
    $new_post = [
        'post_title' => $post_title,
        'post_content' => $post_content,
        'post_status' => 'publish',
        'post_date' => date('Y-m-d H:i:s'),
        'post_author' => $user_ID,
        'post_type' => 'post',
        'post_category' => [8, $cat_id],
    ];
    $post_id = wp_insert_post($new_post);
}
add_action('wp_ajax_update_brand', 'update_brand');

function update_brand()
{
    global $wpdb;
    $error = [];
    $updateArr = [];
    $format = [];
    $bid = esc_sql($_POST['bid']);
    $mess = '';
    $result = $wpdb->get_results("SELECT * FROM wp_brands WHERE bid ='$bid'");
    foreach ($result as $key => $service) {
        if (isset($_POST['destinationName'][$key])) {
            $brand = esc_sql($_POST['destinationName']);
            if ($result[$key]->name !== $brand) {
                array_push($updateArr, ['name' => $brand]);
                array_push($format, '%s');
            }
        }

        if ($_FILES['carBrand']['name'][$key] !== null && !empty($_FILES['carBrand']['name'][$key])) {
            if (isset($_FILES['carBrand']['name'][$key])) {
                $target_file = $_FILES['carBrand']['name'][$key];
                $icon = $brand . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_FILES['carBrand']['name']) && $_FILES['carBrand']['name'] !== $icon) {
                    array_push($updateArr, ['icon' => $icon]);
                    array_push($format, '%s');

                    uploadBrand($bid, $_FILES, $brand);
                }
            }
        }

        $table_name = $wpdb->prefix . 'brands'; //try not using Uppercase letters or blank spaces when naming db tables

        $where = ['bid' => $bid];

        ($wpdb->update($table_name, array_reduce($updateArr, 'array_merge', []), $where, $format)) ? $mess = "Updated" : $mess = false;
    }
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '&status=' . $mess);
    exit();
}

function uploadBrand($id = null, $icon, $name)
{
    $mess = [];
    foreach ($_FILES['carBrand']['tmp_name'] as $key => $image) {
        $target_dir = get_template_directory() . "/img/brands/";
        $target_file = $target_dir . basename($_FILES['carBrand']['name'][$key]);
        $targ = $target_dir . basename($name . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION)));

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targ, PATHINFO_EXTENSION));
        $newfilename = $name . '.' . $imageFileType;

        // Check if image file is a actual image or fake image
        if (isset($_FILES['carBrand'])) {
            $check = getimagesize($_FILES['carBrand']['tmp_name'][$key]);
            if ($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo 'File is not an image uploadBrand.';
                $uploadOk = 0;
                exit(print_r($imageFileType));
            }
            // Check if file already exists
            if (file_exists($targ)) {
                unlink($targ);
                array_push($mess, ['imageExists' => 'Sorry, file already exists.']);
                $uploadOk = 1;
            }

            // Check file size
            if ($_FILES['carBrand']['size'][$key] > 900000) {
                $uploadOk = 0;
                array_push($mess, ['sizeFail' => 'Sorry, your file is too large.' . $_FILES['carBrand']['size'][$key]]);
            }

            // Allow certain file formats
            if (
                $imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
                && $imageFileType != 'svg'
            ) {
                $uploadOk = 0;
                array_push($mess, ['formatFail' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($mess, ['uploadStat' => 'Sorry, your file was not uploaded.']);
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['carBrand']['tmp_name'][$key], $targ)) {
                    array_push($mess, json_encode('The file ' . htmlspecialchars(basename($newfilename)) . ' has been uploaded.'));
                } else {
                    array_push($mess, json_encode('Sorry, there was an error uploading your file.'));
                }
            }
        }

        array_unshift($mess, ['status' => $uploadOk]);
        $mess[0] = ['status' => $uploadOk];
        if ($mess[0]['status'] === 1) {
            return $mess[0]['status'];
        } else {
            print_r('Error Uploading the picture, Function uploadBrand');
        }
    }
}

function uploadCarImage($id = null, $icon, $name)
{
    $mess = [];
    foreach ($_FILES['carBrand']['tmp_name'] as $key => $image) {
        $target_dir = get_template_directory() . "/img/cars/";

        $target_file = $target_dir . basename($_FILES['carBrand']['name'][$key]);
        $targ = $target_dir . basename($name . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION)));

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targ, PATHINFO_EXTENSION));
        $newfilename = $name . '.' . $imageFileType;
        // Check if image file is a actual image or fake image
        if (isset($_FILES['carBrand'])) {
            $check = getimagesize($_FILES['carBrand']['tmp_name'][$key]);
            if ($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo 'File is not an image uploadBrand.';
                $uploadOk = 0;
                exit(print_r($imageFileType));
            }

            // Check if file already exists
            if (file_exists($targ)) {
                unlink($targ);
                array_push($mess, ['imageExists' => 'Sorry, file already exists.']);
                $uploadOk = 1;
            }

            // Check file size
            if ($_FILES['carBrand']['size'][$key] > 900000) {
                $uploadOk = 0;
                array_push($mess, ['sizeFail' => 'Sorry, your file is too large.' . $_FILES['carBrand']['size'][$key]]);
            }

            // Allow certain file formats
            if (
                $imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
                && $imageFileType != 'svg'
            ) {
                $uploadOk = 0;
                array_push($mess, ['formatFail' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                array_push($mess, ['uploadStat' => 'Sorry, your file was not uploaded.']);
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES['carBrand']['tmp_name'][$key], $targ)) {
                    array_push($mess, json_encode('The file ' . htmlspecialchars(basename($newfilename)) . ' has been uploaded.'));
                } else {
                    array_push($mess, json_encode('Sorry, there was an error uploading your file.'));
                }
            }
        }

        array_unshift($mess, ['status' => $uploadOk]);
        $mess[0] = ['status' => $uploadOk];
        if ($mess[0]['status'] === 1) {
            return $mess[0]['status'];
        } else {
            print_r('Error Uploading the picture, Function upload_CarImage');
            print_r($mess);
        }
    }
}

function deleteIcon($name)
{
    $filename = $_SERVER['DOCUMENT_ROOT'] . 'wp-content/themes/AweAfrica/img/destinations/' . $name;
    if (file_exists($filename)) {
        unlink($filename);

        return 'File ' . $filename . ' has been deleted';
    } else {
        return 'Could not delete ' . $filename . ', file does not exist';
    }
    exit;
}
add_action('wp_ajax_update_car', 'update_car');

function update_car()
{
    global $wpdb;
    $error = [];
    $updateArr = [];
    $format = [];
    $icon = '';
    $servid = esc_sql($_POST['bid']);
    $result = $wpdb->get_results("SELECT * FROM wp_cars WHERE cid = $servid");


    
    foreach ($result as $key => $car) {
        if (isset($_POST['namecar'])) {
            $brand = esc_sql($_POST['namecar']);
            if ($car->name !== $brand) {
                array_push($updateArr, ['name' => $brand]);
                array_push($format, '%s');
            }
        }

        if (isset($_FILES['carBrand']['name'][$key])) {
            if ($_FILES['carBrand']['name'][$key] !== $car->pictures && !empty($_FILES['carBrand']['name'][$key])) {
                $target_file = $_FILES['carBrand']['name'][$key];
                $icon = $brand . '.' . strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                if (isset($_FILES['carBrand']['name']) && $_FILES['carBrand']['name'] !== $icon) {
                    array_push($updateArr, ['pictures' => $icon]);
                    array_push($format, '%s');

                    (!empty($_FILES)) ? uploadCarImage($servid, $_FILES, $brand) : ' ';
                }
            }
        } else {
            echo 'Haibo';
        }
        

        $table_name = $wpdb->prefix . 'cars'; //try not using Uppercase letters or blank spaces when naming db tables

        $where = ['cid' => $servid];

        $wpdb->update($table_name, array_reduce($updateArr, 'array_merge', []), $where, $format);
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function delCar($serviceName)
{
    global $wpdb;
    $result = "";

    if (!empty($serviceName)) {
        foreach ($serviceName as $sub) {
            // Delete all destinations.
            $post = get_page_by_title($sub->name, OBJECT, 'post');

            //Delete from cars table 1111111
            if ($wpdb->query($wpdb->prepare("DELETE FROM `wp_cars` WHERE `cid` = '%d'", $sub->id))) {
                $result = true;

                //Delete from the posts table by post id
                if ($result) {
                    if (wp_delete_post($post->ID)) {
                        $result = true;
                    }
                } else {
                    print_r("Error in function delCar, couldn't delete the cars");
                    $result = false;
                }
            } else {
                //if no data found, make the $result true so that it can return true, and it can delete the Service from Service table
                $result = true;
            }
        }
    } else {
        //if no data found, make the $result true so that it can return true, and it can delete the Service from Service table
        $result = true;
    }

    return $result + "delCar";
}

ob_clean();
?>