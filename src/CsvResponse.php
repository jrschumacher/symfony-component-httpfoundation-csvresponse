<?php

namespace Symfony\Component\HttpFoundation;
use Goodby\CSV\Export\Standard\Exporter;
use Goodby\CSV\Export\Standard\ExporterConfig;

/**
 * Response represents an HttpFoundation in CSV format.
 *
 * @author Ryan Schumacher <ryan@38pages.com>
 */
class CsvResponse extends StreamedResponse
{

    private $exporterConfig;

    /**
     * Constructor.
     *
     * @param mixed   $data    The response data or callback
     * @param int     $status  The response status code
     * @param array   $headers An array of response headers
     */
    public function __construct($data = array(), $status = 200, $headers = array())
    {
        if(!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'text/csv';
        }

        parent::__construct(null, $status, $headers);

        $this->exporterConfig = new ExporterConfig();

        // If a callback is passed
        if(is_callable($data)) {
            $this->setCallback($data);
        }
        else {
            $self = $this;
            $this->setCallback(function() use($self, $data) {
                $exporter = new Exporter($self->exporterConfig);

                $exporter->export('php://output', $data);
            });
        }

        $this->streamed = false;
    }

    public function &getExporterConfig() {
        return $this->exporterConfig;
    }

    public function setExporterConfig(ExporterConfig &$exporterConfig) {
        $this->exporterConfig = $exporterConfig;
    }
}