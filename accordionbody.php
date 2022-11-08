<div class="container">
    <div class="row">
        <div class="col accordion" id="accordionExample">
            <?php
                global $wpdb;
                $query = 'SELECT * FROM `wp_brands`';
                $out = '';
                $subout = '';
                $result = $wpdb->get_results($query);
                if (!count($result) == 0) {
                    for ($i = 0; $i < count($result); ++$i) {
                        $pic = '';
                        $dt = get_template_directory_uri();
                        (!empty($result[$i]->icon)) ? $pic .= '<div style="height: 100%; width auto; overflow: hidden"><img src="http://awe.africa/wp-content/themes/AweAfrica/img/destinations/' . $result[$i]->icon . '" alt="" data-name="' . $result[$i]->name . '" style="max-height: 150px;"></div>' : $pic .= '<input type="file" name="newBrand[]" id="service_icon">'; ?>
            <div class="accordion-item">
                <h2 class="accordion-header"
                    id="heading<?php echo strtolower(str_replace(' ', '-', $result[$i]->name)); ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?php echo strtolower(str_replace(' ', '-', $result[$i]->name)); ?>"
                        aria-expanded="false"
                        aria-controls="collapse<?php echo strtolower(str_replace(' ', '-', $result[$i]->name)); ?>">
                        <?php echo $result[$i]->name; ?>
                    </button>
                </h2>
                <div id="collapse<?php echo strtolower(str_replace(' ', '-', $result[$i]->name)); ?>"
                    class="accordion-collapse collapse"
                    aria-labelledby="heading<?php echo strtolower(str_replace(' ', '-', $result[$i]->name)); ?>"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-7">

                                    <?php require('car.php'); ?>
                                </div>
                                <div class="col-md-5">
                                    <?php require('editBrand.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } ?>

        </div>
    </div>
</div>