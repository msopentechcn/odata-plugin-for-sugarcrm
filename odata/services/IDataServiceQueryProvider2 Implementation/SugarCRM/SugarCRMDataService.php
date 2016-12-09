<?php

/**
 * Implementation of IServiceProvider.
 * 
 * PHP version 5.3
 * 
 * @category  Service
 * @package   SugarCRM
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   SVN: 1.0
 * @link      http://odataphpproducer.codeplex.com
 * 
 */
use ODataProducer\Configuration\EntitySetRights;

use ODataProducer\IDataService;
use ODataProducer\IRequestHandler;
use ODataProducer\DataService;
use ODataProducer\IServiceProvider;

use ODataProducer\Configuration\DataServiceProtocolVersion;
use ODataProducer\Configuration\DataServiceConfiguration;
use ODataProducer\OperationContext\DataServiceHost;
use ODataProducer\Common\ODataException;
use ODataProducer\Common\ODataConstants;
use ODataProducer\Common\Messages;
use ODataProducer\UriProcessor\UriProcessor;

require_once 'SugarCRMMetadata.php';
require_once 'SugarCRMQueryProvider.php';
require_once 'SugarCRMDSExpressionProvider.php';

/**
 * NorthWindDataService that implements IServiceProvider.
 * 
 * @category  Service
 * @package   SugarCRM
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   Release: 1.0
 * @link      http://odataphpproducer.codeplex.com
 */
class SugarCRMDataService extends DataService implements IServiceProvider {

    private $_SugarCRMMetadata = null;
    private $_SugarCRMQueryProvider = null;
    private $_SugarCRMExpressionProvider = null;

    /**
     * This method is called only once to initialize service-wide policies
     * 
     * @param DataServiceConfiguration &$config Data service configuration object
     * 
     * @return void
     */
    public function initializeService(DataServiceConfiguration &$config) {
        $config->setEntitySetPageSize('*', 5);
        $config->setEntitySetAccessRule('*', EntitySetRights::ALL);
        $config->setAcceptCountRequests(true);
        $config->setAcceptProjectionRequests(true);
        $config->setMaxDataServiceVersion(DataServiceProtocolVersion::V3);
    }

    /**
     * Get the service like IDataServiceMetadataProvider, IDataServiceQueryProvider,
     * IDataServiceStreamProvider
     * 
     * @param String $serviceType Type of service IDataServiceMetadataProvider, 
     *                            IDataServiceQueryProvider,
     *                            IDataServiceStreamProvider
     * 
     * @see library/ODataProducer/ODataProducer.IServiceProvider::getService()
     * @return object
     */
    public function getService($serviceType) {
        if (($serviceType === 'IDataServiceMetadataProvider') ||
                ($serviceType === 'IDataServiceQueryProvider2') ||
                ($serviceType === 'IDataServiceStreamProvider')) {
            if (is_null($this->_SugarCRMExpressionProvider)) {
                $this->_SugarCRMExpressionProvider = new SugarCRMDSExpressionProvider();
            }
        }
        if ($serviceType === 'IDataServiceMetadataProvider') {
            if (is_null($this->_SugarCRMMetadata)) {
                $this->_SugarCRMMetadata = CreateSugarCRMMetadata::create();
                // $this->_SugarCRMMetadata->mappedDetails = CreateSugarCRMMetadata::mappingInitialize();
            }
            return $this->_SugarCRMMetadata;
        } else if ($serviceType === 'IDataServiceQueryProvider2') {
            if (is_null($this->_SugarCRMQueryProvider)) {
                $this->_SugarCRMQueryProvider = new SugarCRMQueryProvider();
            }
            return $this->_SugarCRMQueryProvider;
        } else if ($serviceType === 'IDataServiceStreamProvider') {
            return new SugarCRMStreamProvider();
        }
        return null;
    }

    // For testing we overridden the DataService::handleRequest method, one thing is the
    // private memeber variable DataService::_dataServiceHost is not accessible in this class,
    // so we are using getHost() below.
}