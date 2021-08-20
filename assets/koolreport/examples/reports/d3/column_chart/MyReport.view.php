<?php
    use \koolreport\d3\ColumnChart;

    $category_amount = array(
        array("category"=>"Books","sale"=>32000,"cost"=>20000,"profit"=>12000),
        array("category"=>"Accessories","sale"=>43000,"cost"=>36000,"profit"=>7000),
        array("category"=>"Phones","sale"=>54000,"cost"=>39000,"profit"=>15000),
        array("category"=>"Movies","sale"=>23000,"cost"=>18000,"profit"=>5000),
        array("category"=>"Others","sale"=>12000,"cost"=>6000,"profit"=>6000),
    );

    $category_sale_month = array(
        array("category"=>"Books","January"=>32000,"February"=>20000,"March"=>12000),
        array("category"=>"Accessories","January"=>43000,"February"=>36000,"March"=>7000),
        array("category"=>"Phones","January"=>54000,"February"=>39000,"March"=>15000),
        array("category"=>"Others","January"=>12000,"February"=>6000,"March"=>6000),
    );
?>
<div class="report-content">
    <div class="text-center">
        <h1>ColumnChart</h1>
        <p class="lead">
            This example shows how to use D3's ColumnChart
        </p>
    </div>
    <div style="margin-bottom:50px;">
    <div class="text-center"><strong>Basic chart</strong></div>
    <?php
    ColumnChart::create(array(
        "dataSource"=>$category_amount,
        "columns"=>array(
            "category",
            "sale"=>array("label"=>"Sale","type"=>"number","prefix"=>"$"),
            "cost"=>array("label"=>"Cost","type"=>"number","prefix"=>"$"),
            "profit"=>array("label"=>"Profit","type"=>"number","prefix"=>"$"),
        )
    ));
    ?>
    </div>
    <div style="margin-bottom:50px;">
    <div class="text-center"><strong>Stacked chart</strong></div>
    <?php
    ColumnChart::create(array(
        "dataSource"=>$category_sale_month,
        "columns"=>array(
            "category",
            "January"=>array("label"=>"January","type"=>"number","prefix"=>"$"),
            "February"=>array("label"=>"February","type"=>"number","prefix"=>"$"),
            "March"=>array("label"=>"March","type"=>"number","prefix"=>"$"),
        ),
        "stacked"=>true
    ));
    ?>
    </div>
    
    <div style="margin-bottom:50px;">
    <div class="text-center"><strong>Dual Axis - Sale and Sale Number</strong></div>
    <?php
    ColumnChart::create(array(
        "dataSource"=>array(
            array("category"=>"Books","sale"=>32000,"number"=>1700,),
            array("category"=>"Accessories","sale"=>43000,"number"=>2100),
            array("category"=>"Phones","sale"=>54000,"number"=>3200),
            array("category"=>"Movies","sale"=>23000,"number"=>9000),
            array("category"=>"Others","sale"=>12000,"number"=>5300),
        ),
        "columns"=>array(
            "category",
            "sale"=>array(
                "label"=>"Sale",
                "type"=>"number",
                "prefix"=>"$"
            ),
            "number"=>array(
                "label"=>"Cost",
                "type"=>"number",
                "prefix"=>"$",
                "axis"=>"y2"
            ),
        ),
        "yAxis"=>array(
            "prefix"=>"$"
        ),
        "dualAxis"=>true
    ));
    ?>
    </div>



</div>
