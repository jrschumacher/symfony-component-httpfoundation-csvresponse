# CSV Response for Symfony HttpFoundation
[![Build Status](https://travis-ci.org/jrschumacher/symfony-component-httpfoundation-csvresponse.png)](https://travis-ci.org/jrschumacher/symfony-component-httpfoundation-csvresponse)

## Use

It should be noted CsvResponse extends StreamedResponse and uses [goodby/csv](https://github.com/goodby/csv) library. The use of this response is relatively simple. 

``` php
<?
use Symfony\Component\HttpFoundation\CsvResponse;

$data = array(
    array('John Smith', 'john@smith.com'),
    array('Jane Smith', 'jane@smith.com')
);

new CsvResponse($data);

```

### Further Use

For further use please see [goodby/csv](https://github.com/goodby/csv)