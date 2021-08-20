<?php
    use \koolreport\chartjs\ColumnChart;
    use \koolreport\chartjs\BarChart;
    use \koolreport\chartjs\PieChart;

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
        <h1>Color Scheme</h1>
        <p class="lead">
            This example shows how to change color scheme for charts.
        </p>
    </div>
    <div style="margin-bottom:50px;">
    <?php
    ColumnChart::create(array(
        "title"=>"Sale Report",
        "dataSource"=>$category_amount,
        "columns"=>array(
            "category",
            "sale"=>array("label"=>"Sale","type"=>"number","prefix"=>"$"),
            "cost"=>array("label"=>"Cost","type"=>"number","prefix"=>"$"),
            "profit"=>array("label"=>"Profit","type"=>"number","prefix"=>"$"),
        ),
        "colorScheme"=>array(
            "#e7717d",
            "#c2cad0",
            "#c2b9b0",
            "#7e685a",
            "#afd275"
        )
    ));
    ?>
    </div>
    <div style="margin-bottom:50px;">
    <?php
    BarChart::create(array(
        "title"=>"Sale Report on Stack",
        "dataSource"=>$category_sale_month,
        "columns"=>array(
            "category",
            "January"=>array("label"=>"January","type"=>"number","prefix"=>"$"),
            "February"=>array("label"=>"February","type"=>"number","prefix"=>"$"),
            "March"=>array("label"=>"March","type"=>"number","prefix"=>"$"),
        ),
        "colorScheme"=>array(
            "#844d36",
            "#474853",
            "#86b3d1",
            "#aaa0a0",
            "#be8268"
        ),
        "options"=>array(
            "isStacked"=>true
        )
    ));
    ?>
    </div>
    

    <?php
    PieChart::create(array(
        "title"=>"Sale Of Category",
        "dataSource"=>$category_amount,
        "columns"=>array(
            "category",
            "cost"=>array(
                "type"=>"number",
                "prefix"=>"$",
            )
        ),
        "colorScheme"=>array(
            "#2f4454",
            "#2e1518",
            "#da7b93",
            "#376e6f",
            "#1c3334"
        )
    ));
    ?>

</div>
