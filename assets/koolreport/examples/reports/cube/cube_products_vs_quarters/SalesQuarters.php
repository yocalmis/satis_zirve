<?php
require_once "../../../load.koolreport.php";
use \koolreport\processes\ColumnMeta;
use \koolreport\processes\Limit;
use \koolreport\processes\Sort;
use \koolreport\processes\RemoveColumn;
use \koolreport\processes\OnlyColumn;
use \koolreport\processes\Filter;
use \koolreport\processes\ValueMap;
use \koolreport\cube\processes\Cube;
use \koolreport\core\Utility;

class SalesQuarters extends koolreport\KoolReport
{
    function settings()
    {
        return array(
            "dataSources" => array(
                "dollarsales"=>array(
                    'filePath' => '../../../databases/customer_product_dollarsales2.csv',
                    'fieldSeparator' => ';',
                    'class' => "\koolreport\datasources\CSVDataSource"      
                ), 
            )
        );
    }
    function setup()
    {
        $salesYear = $this->params["salesYear"];

        $node = $this->src('dollarsales')
        ->pipe(new ColumnMeta(array(
            "dollar_sales"=>array(
                'type' => 'number',
                "prefix" => "$",
            ),
        )))
        ->pipe(new ValueMap(array(
            'orderQuarter' => array(
                '{func}' => function ($value) {
                    return 'Q' . $value;
                },
                "{meta}" => array(
                    "type" => "string"
                ),
            )
        )));
        
        $filters = array('or');
        foreach ($salesYear as $year)
            array_push($filters, array('orderYear', '=', ''.$year));
        $node = $node->pipe(new Filter($filters));
        
        $node->pipe($this->dataStore('salesFilter'));
        
        $node->pipe(new Cube(array(
            "row" => "productName",
            "column" => "orderQuarter",
            "sum" => "dollar_sales"
        )))
        ->pipe(new Sort(array(
            '{{all}}' => 'desc'
        )))
        ->pipe(new Limit(array(
            5, 0
        )))->pipe(new ColumnMeta(array(
            "{{all}}"=>array(
                "label"=>"Total",
            ),
            "productName"=>array(
                "label"=>"Product",
            ),
        )))->saveTo($node2);
        
        $node2->pipe($this->dataStore('salesQuarterProductName'));
        
        $node2->pipe(new RemoveColumn(array(
            "{{all}}"
        )))
        ->pipe($this->dataStore('salesQuarterProductNameNoAll'));
        
        $node2->pipe(new OnlyColumn(array(
            'productName', "{{all}}"
        )))->pipe($this->dataStore('salesQuarterProductNameAll'));
        
    }
}
