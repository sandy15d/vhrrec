<?php
include 'config.php';
include 'cdns.php';
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Jobs at VNR</title>
    <link rel='stylesheet' id='avada-stylesheet-css' href='<?= $projectURL ?>css/fusion/style.css' type='text/css' media='all' />
    <link rel='stylesheet' id='fusion-dynamic-css-css' href='<?= $projectURL ?>css/fusion/fusion.css' type='text/css' media='all' />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css' type='text/css' />
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='<?= $projectURL ?>js/jquery_v1.js'></script>

    <link rel="shortcut icon" href="<?= $projectURL ?>assets/favicon.png" type="image/x-icon">
    <style>
        .table td,
        .table th {
            font-family: "Cambria", serif;
        }
    </style>
</head>
<?php
$allco = query("SELECT * FROM `master_company` where Status = 'A'");
while ($allcod = fetch_assoc($allco)) {
    $coarr[$allcod['CompanyId']] = $allcod['CompanyName'];
}

$allde = query("SELECT * FROM `master_department` where DeptStatus = 'A'");
while ($allded = fetch_assoc($allde)) {
    $dearr[$allded['DepartmentId']] = $allded['DepartmentName'];
}

$alldes = query("SELECT * FROM `master_designation` where DesigStatus = 'A'");
while ($alldesd = fetch_assoc($alldes)) {
    $desarr[$alldesd['DesigId']] = $alldesd['DesigName'];
}
$allci = query("SELECT * FROM `districts` where status = 'A'");
while ($allcid = fetch_assoc($allci)) {
    $ciarr[$allcid['id']] = $allcid['name'];
}

$alled = query("SELECT * FROM `master_education` order by EducationCode asc");
while ($alledd = fetch_assoc($alled)) {
    $edarr[$alledd['EducationId']] = $alledd['EducationCode'];
}

$alleds = query("SELECT * FROM `master_specialization` order by Specialization asc");
while ($alledds = fetch_assoc($alleds)) {
    $edsparr[$alledds['SpId']] = $alledds['Specialization'];
    $edspeduarr[$alledds['SpId']] = $edarr[$alledds['EducationId']];
}

$allemp = query("SELECT * FROM `master_employee` where EmpStatus = 'A' ");
while ($allempd = fetch_assoc($allemp)) {
    $name = $allempd['Fname'];
    if ($allempd['Sname'] != '') {
        $name .= ' ' . $allempd['Sname'];
    }
    if ($allempd['Lname'] != '') {
        $name .= ' ' . $allempd['Lname'];
    }
    $emparr[$allempd['EmpCode']] = $name;
}



$allst = query("SELECT * FROM `states` where status = 'A' ");
while ($allstd = fetch_assoc($allst)) {
    $starr[$allstd['id']] = $allstd['name'];
}

?>

<body class="page-template page-template-100-width page-template-100-width-php page page-id-2239 has-dashicons unselectable tribe-no-js fusion-image-hovers fusion-body ltr fusion-sticky-header no-tablet-sticky-header no-mobile-sticky-header no-mobile-slidingbar fusion-disable-outline fusion-sub-menu-fade mobile-logo-pos-left layout-wide-mode fusion-top-header menu-text-align-center mobile-menu-design-modern fusion-hide-pagination-text fusion-header-layout-v3 avada-responsive avada-footer-fx-none fusion-search-form-classic fusion-avatar-square">
    <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
    <div id="wrapper" class="">
        <div id="home" style="position:relative;top:-1px;"></div>
        <div class="fusion-secondary-header">
            <div class="fusion-row">
                <div class="fusion-alignleft">
                    <nav class="fusion-secondary-menu" role="navigation" aria-label="Secondary Menu"></nav>
                </div>
                <div class="fusion-alignright">
                    <div class="fusion-social-links-header">
                        <div class="fusion-social-networks">
                            <div class="fusion-social-networks-wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fusion-header-sticky-height"></div>
        <main id="main" class="clearfix width-100" style="padding-left:30px;padding-right:30px">
            <div class="fusion-row" style="max-width:100%;">
                <section id="content" class="full-width">
                    <div id="post-2239" class="post-2239 page type-page status-publish hentry">
                        <div class="post-content">
                            <div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling" style='background-color: #ffffff;background-position: left top;background-repeat: no-repeat;padding-top:30px;padding-right:30px;padding-bottom:-0.5%;padding-left:30px;border-top-width:0px;border-bottom-width:0px;border-color:#e7e4e2;border-top-style:solid;border-bottom-style:solid;'>
                                <div class="fusion-builder-row fusion-row ">
                                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_6 fusion-builder-column-1 fusion-one-sixth fusion-column-first fusion-no-small-visibility 1_6" style='margin-top:10px;margin-bottom:10px;width:13.3333%; margin-right: 4%;'>
                                        <div class="fusion-column-wrapper" style="padding: 0px 0px 0px 0px;background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
                                            <div class="fusion-clearfix"></div>
                                        </div>
                                    </div>
                                    <div class="fusion-layout-column fusion_builder_column fusion_builder_column_2_3 fusion-builder-column-2 fusion-two-third 2_3" style='margin-top:10px;margin-bottom:10px;width:65.3333%; margin-right: 4%;'>
                                        <div class="fusion-column-wrapper">
                                            <div class="imageframe-align-center"><span class="fusion-imageframe imageframe-none imageframe-1 hover-type-none"><img src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" data-orig-src="https://www.vnrseeds.com/wp-content/uploads/2018/12/vnr-logo-69x90.png" width="69" height="90" alt="" title="vnr-logo-69×90" class="img-responsive wp-image-650 lazyloaded"></span></div>
                                            <div class="fusion-text">
                                                <h3 style="text-align: center;"><span style="color: #f09a3e;">Engage,
                                                        Train &amp; Retain<br />
                                                    </span>
                                                </h3>
                                            </div>
                                            <div class="fusion-text">
                                                <p style="text-align: center; font-size: 20px;">At VNR, our most
                                                    valuable assets are its people
                                                </p>
                                            </div>
                                            <div class="fusion-separator sep-single sep-solid" style="border-color:#01833c;border-top-width:2px;margin-left: auto;margin-right: auto;max-width:170px;">
                                            </div>
                                            <div class="fusion-title title fusion-title-1 fusion-sep-none fusion-title-size-three fusion-border-below-title" style="margin-top:0%;margin-bottom:0%;">
                                                <h3 data-fontsize="24" data-lineheight="33"><span style="color: #008000;"><strong>Current Openings at
                                                            VNR</strong></span>
                                                </h3>
                                            </div>
                                            <div class="fusion-clearfix"></div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped table-sm" id="myTable" style="width:100%">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>#</th>
                                                            <th>Job Code</th>
                                                            <th>Job Title</th>
                                                            <th>Department</th>

                                                            <th>Apply</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="panel">
                                                        <?php
                                                        $allc = query("SELECT j.*,mr.* FROM `jobpost` j, `manpowerrequisition` mr where j.MRFId=mr.MRFId and mr.CompanyId=1 and j.Status='Open' and j.PostingView='Show' order by JPId desc");
                                                        $i = 1;
                                                        while ($allcd = fetch_assoc($allc)) {
                                                        ?>
                                                            <tr data-toggle="collapse" data-target="#detail<?= $allcd['JPId'] ?>" data-parent="#myTable" class="accordion-toggle">
                                                                <td style="vertical-align: middle; text-align:center">
                                                                    <?= $i; ?>
                                                                </td>
                                                                <td style="cursor:pointer;vertical-align: middle;">
                                                                    <?= $allcd['JobCode'] ?>
                                                                </td>
                                                                <td style="cursor:pointer;vertical-align: middle;">
                                                                    <?= $allcd['Title'] ?>
                                                                </td>
                                                                <td style="vertical-align: middle; ">
                                                                    <?= $dearr[$allcd['DepartmentId']] ?>
                                                                </td>

                                                                <td style="vertical-align: middle; text-align:center">
                                                                    <a href="#" style="color:blue">View
                                                                        Details</a>
                                                                </td>
                                                            </tr>
                                                            <tr id="detail<?= $allcd['JPId'] ?>" class="collapse accordian-body">
                                                                <td colspan="6" class="hiddenRow">
                                                                    <div>
                                                                        <table class="table table-bordered table-striped table-sm">
                                                                            <?php
                                                                            $sql = query("SELECT j.*,mr.EducationId,mr.WorkExp,mr.LocationIds FROM `jobpost` j, `manpowerrequisition` mr where j.MRFId=mr.MRFId  and j.Status='Open' AND j.JPId='" . $allcd['JPId'] . "' order by JPId desc");
                                                                            while ($res = fetch_assoc($sql)) {
                                                                            ?>
                                                                                <tr>
                                                                                    <td colspan="2"><?= $res['Title'] ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="width:200px;">Job Code</td>
                                                                                    <td>
                                                                                        <?= $res['JobCode'] ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Job Category</td>
                                                                                    <td> <?= $dearr[$res['DepartmentId']] ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Job Description</td>
                                                                                    <td><?= $res['Description'] ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Desired Candidate Profile</td>
                                                                                    <td> <?php
                                                                                            error_reporting(0);/*here showing error of using preg_replace, that's why using error_reporting(0) */
                                                                                            $data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $res['KeyPositionCriteria']);

                                                                                            $allkp = unserialize($data);


                                                                                            if (count($allkp) > 0) {
                                                                                                $a = '<li style=" margin-left:25px;">';
                                                                                                foreach ($allkp as $key => $value) {
                                                                                                    echo  $a . ' ' . $value . '<br>';
                                                                                                }
                                                                                            }

                                                                                            ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Education Qualification</td>
                                                                                    <td> <?php
                                                                                            $a = unserialize($res['EducationId']);

                                                                                            if (count($a) > 0) {

                                                                                                foreach ($a as $key => $value) {

                                                                                                    $education = ' ';
                                                                                                    if ($value['e'] != ''  && $value['e'] != 0) {
                                                                                                        $education .= $edarr[$value['e']];
                                                                                                        if ($value['s'] != '' && $value['s'] != '') {
                                                                                                            $education .=   '-' . $edsparr[$value['s']];
                                                                                                        }
                                                                                                    }
                                                                                                    echo $education . '</li><br>';
                                                                                                }
                                                                                            }
                                                                                            ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Work Experience</td>
                                                                                    <td><?= $res['WorkExp'] ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Job Location</td>
                                                                                    <td><?php
                                                                                        $a = unserialize($res['LocationIds']);
                                                                                        if (count($a) > 0) {
                                                                                            $li = 1;
                                                                                            foreach ($a as $key => $value) {
                                                                                                $loc = '';
                                                                                                if ($value['city'] != '') {
                                                                                                    $loc .= $ciarr[$value['city']] . '(';
                                                                                                }
                                                                                                if ($value['state'] != '') {
                                                                                                    $loc .= $starr[$value['state']];
                                                                                                }
                                                                                                if ($value['city'] != '') {
                                                                                                    $loc .= ')';
                                                                                                }

                                                                                                echo $loc . '<br>';
                                                                                                $li++;
                                                                                            }
                                                                                        } else {
                                                                                            if (isset($ciarr[$a[0]])) {
                                                                                                echo $ciarr[$a[0]];
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Salary Package</td>
                                                                                    <td>Best as per industry standards</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2" class="text-center">
                                                                                        <button type="button" class="btn btn-sm btn-primary" onclick="jobapply('<?= $res['JPId'] ?>')">Apply
                                                                                            Now
                                                                                    </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <p style="line-height: initial;">Thanks for checking out our job openings. if you don't see any
                                                opportunities, please submit your resume & we'll get back to you if
                                                there any suitable openings that match your profile. <b><a href="https://recruitment.vnress.in/jobPortal/jobapply.php">Submit your resume</a></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- fusion-row -->
        </main>
        <!-- #main -->
    </div>
    <!-- wrapper -->
    <form id="jaform" method="POST" action="jobPortal/jobPostApply.php" target="_blank">
        <input type="hidden" name="jpid" id="jpid" value="">
        <input type="hidden" name="CurrentForm" value="ResumeForm">
    </form>
</body>
<script type='text/javascript' src='<?= $projectURL ?>js/modernizer.js'></script>
<script type='text/javascript'>
    var avadaHeaderVars = {
        "header_position": "top",
        "header_layout": "v3",
        "header_sticky": "1",
        "header_sticky_type2_layout": "menu_and_logo",
        "header_sticky_shadow": "1",
        "side_header_break_point": "1150",
        "header_sticky_mobile": "0",
        "header_sticky_tablet": "0",
        "mobile_menu_design": "modern",
        "sticky_header_shrinkage": "0",
        "nav_height": "126",
        "nav_highlight_border": "0",
        "nav_highlight_style": "bar",
        "logo_margin_top": "24px",
        "logo_margin_bottom": "22px",
        "layout_mode": "wide",
        "header_padding_top": "0px",
        "header_padding_bottom": "0px",
        "offset_scroll": "full"
    };
</script>
<script>
    /* $('.accordion-toggle').click(function() {
    $('.hiddenRow').hide();
    $(this).next('tr').find('.hiddenRow').show();
}); */
</script>
<script type='text/javascript' src='<?= $projectURL ?>js/avada-header.js'></script>
<script type='text/javascript'>
    var fusionTypographyVars = {
        "site_width": "1280px",
        "typography_responsive": "1",
        "typography_sensitivity": "1.00",
        "typography_factor": "1.50",
        "elements": "h1, h2, h3, h4, h5, h6"
    };
</script>
<script type='text/javascript' src='<?= $projectURL ?>js/typography.js'></script>
<script type="text/javascript">
    function jobapply(id) {
        $('#jpid').val(id);
        $('#jaform').submit();

    }
</script>

</html>