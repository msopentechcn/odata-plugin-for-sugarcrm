<?php
/** 
 * Implementation of IDataServiceQueryProvider.
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
use ODataProducer\UriProcessor\ResourcePathProcessor\SegmentParser\KeyDescriptor;
use ODataProducer\Providers\Metadata\ResourceSet;
use ODataProducer\Providers\Metadata\ResourceProperty;
use ODataProducer\Providers\Query\IDataServiceQueryProvider2;
use ODataProducer\Common\ODataException;
require_once "SugarCRMMetadata.php";


/**
 * SugarCRMQueryProvider implemetation of IDataServiceQueryProvider.
 * 
 * @category  Service
 * @package   SugarCRM
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   Release: 1.0
 * @link      http://odataphpproducer.codeplex.com
 */
class SugarCRMQueryProvider implements IDataServiceQueryProvider2
{
	/**
	 * The not implemented error message
	 * @var string
	 */
	private $_message = 'This functionality is nnot implemented as the class is only for testing IExpressionProvider for MySQL';

    /**
     * Reference to the custom expression provider
     *
     * @var NorthWindDSExpressionProvider
     */
    private $_SugarCRMMySQLExpressionProvider;
    
    /**
     * Constructs a new instance of SugarCRMQueryProvider
     * 
     */
    private $_connectionHandle = null;
    public function __construct()
    {
        $this->_connectionHandle = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, true);
        if ( $this->_connectionHandle ) {
        } else {             
             die(print_r(mysql_error(), true));
        } 

        mysql_select_db(DB_NAME, $this->_connectionHandle);
    }

     public function canApplyQueryOptions()
    {
        return true;
    }
    
    /**
     * (non-PHPdoc)
     * @see ODataProducer\Providers\Query.IDataServiceQueryProvider2::getExpressionProvider()
     */
    public function getExpressionProvider()
    {
    	if (is_null($this->_SugarCRMMySQLExpressionProvider)) {
    		$this->_SugarCRMMySQLExpressionProvider = new SugarCRMDSExpressionProvider();
    	}
    	
    	return $this->_SugarCRMMySQLExpressionProvider;
    }
    
    /**
     * Gets collection of entities belongs to an entity set
     * 
     * @param ResourceSet      $resourceSet   The entity set whose 
     *                                        entities needs to be fetched
     * @param string           $filterOption  Contains the filter condition
     * @param string           $select        For future purpose,no need to pass it
     * @param string           $orderby       For future purpose,no need to pass it
     * @param string           $top           For future purpose,no need to pass it
     * @param string           $skip          For future purpose,no need to pass it
     * 
     * @return array(Object)
     */
    public function getResourceSet(ResourceSet $resourceSet,$filter=null,$select=null,$orderby=null,$top=null,$skip=null)
    {
    	//ODataException::createNotImplementedError($this->_message);
        $resourceSetName =  $resourceSet->getName();
//        if ($resourceSetName !== 'Contacts') {
//            die('(SugarCRMQueryProvider) Unknown resource set ' . $resourceSetName);
//        }


        $returnResult = array();
        
        //sugarodata record deleted =0
        $sql = "select name from suga_sugarodata where deleted =0 order by id asc";
        $res = mysql_query($sql);
        while ($record = mysql_fetch_array($res, MYSQL_ASSOC)) {
            //get odata tables
            $tables[] = $record['name'];
        }

        if (!empty($tables) && in_array(strtolower($resourceSetName), $tables)) {     
            foreach($tables as $k => $v) {
                if($v == strtolower($resourceSetName)) {
                    $query = "SELECT * FROM `".$v."`";
                    if ($filter !== null) {
                        $query .= " WHERE $filter";
                    }
                    $stmt = mysql_query($query); 
                    $tmp = array();
                    while ($record = mysql_fetch_array($stmt, MYSQL_ASSOC)) {
                        //get table field and type
                        $sqlt = "desc " . $v;
                        $rest = mysql_query($sqlt);

                        //set tabel class
                        $$v = new stdClass();
                        while ($rect = mysql_fetch_array($rest, MYSQL_ASSOC)) {                                
                            $$v->$rect['Field'] = $record[$rect['Field']];
                        }
                        $tmp[] = $$v;
                    }
                }
            }
        }
        
        $returnResult = $tmp;
//        $returnResult = $this->getReturnResult();
//        switch ($resourceSetName) {
//        case 'Contacts':
//            $query = "SELECT * FROM `contacts`";
//            if ($filter !== null) {
//                $query .= " AND $filter";
//            }
//            $stmt = mysql_query($query); 
//            $returnResult = $this->_serializeContact($stmt);     
//            break;                   
//        }
//        mysql_free_result($stmt);
        return $returnResult;
    }


    /**
     * Gets an entity instance from an entity set identifed by a key
     * 
     * @param ResourceSet   $resourceSet   The entity set from which an entity 
     *                                     needs to be fetched
     * @param KeyDescriptor $keyDescriptor The key to identify the entity 
     *                                     to be fetched
     * 
     * @return Object/NULL Returns entity instance if found else null
     */
    public function getResourceFromResourceSet(ResourceSet $resourceSet, KeyDescriptor $keyDescriptor)
    {
    	//ODataException::createNotImplementedError($this->_message);
        $resourceSetName =  $resourceSet->getName();
        if ($resourceSetName !== 'Contacts' 
        ) {
            die('(SugarCRMQueryProvider) Unknown resource set ' . $resourceSetName);
        }

        $namedKeyValues = $keyDescriptor->getNamedValues();
        $condition = null;
        foreach ($namedKeyValues as $key => $value) {
        $condition .= $key . ' = ' . $value[0] . ' AND ';
        }
        $len = strlen($condition);
        $condition = substr($condition, 0, $len - 5);
        $query = "SELECT * FROM "."$resourceSetName"." WHERE ".$condition;
        $stmt = mysql_query($query);
         if (!mysql_num_rows($stmt)) {
                return null;
            }
        $data = mysql_fetch_assoc($stmt);
        
        
        switch ($resourceSetName) {
        case 'Contacts':
            $result = $this->_serializeContacts($data);
            break;
        }
        
        mysql_free_result($stmt);
        return $result;
    
    }
    
    /**
     * Get related resource set for a resource
     * 
     * @param ResourceSet      $sourceResourceSet    The source resource set
     * @param mixed            $sourceEntityInstance The resource
     * @param ResourceSet      $targetResourceSet    The resource set of 
     *                                               the navigation property
     * @param ResourceProperty $targetProperty       The navigation property to be 
     *                                               retrieved
     * @param string           $filterOption         Contains the filter condition
     * @param string           $select               For future purpose,no need to pass it
     * @param string           $orderby              For future purpose,no need to pass it
     * @param string           $top                  For future purpose,no need to pass it
     * @param string           $skip                 For future purpose,no need to pass it
     *                                               
     * @return array(Objects)/array() Array of related resource if exists, if no 
     *                                related resources found returns empty array
     */
    public function  getRelatedResourceSet(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty,
        $filter=null ,$select=null, $orderby=null, $top=null, $skip=null
    ) {
    	ODataException::createNotImplementedError($this->_message);
    }
    
    /**
     * Gets a related entity instance from an entity set identifed by a key
     * 
     * @param ResourceSet      $sourceResourceSet    The entity set related to
     *                                               the entity to be fetched.
     * @param object           $sourceEntityInstance The related entity instance.
     * @param ResourceSet      $targetResourceSet    The entity set from which
     *                                               entity needs to be fetched.
     * @param ResourceProperty $targetProperty       The metadata of the target 
     *                                               property.
     * @param KeyDescriptor    $keyDescriptor        The key to identify the entity 
     *                                               to be fetched.
     * 
     * @return Object/NULL Returns entity instance if found else null
     */
    public function  getResourceFromRelatedResourceSet(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty,
        KeyDescriptor $keyDescriptor
    ) {
    	ODataException::createNotImplementedError($this->_message);
        $result = array();
    } 
    
    /**
     * Get related resource for a resource
     *
     * @param ResourceSet      $sourceResourceSet    The source resource set
     * @param mixed            $sourceEntityInstance The source resource
     * @param ResourceSet      $targetResourceSet    The resource set of
     *                                               the navigation property
     * @param ResourceProperty $targetProperty       The navigation property to be
     *                                               retrieved
     *
     * @return Object/null The related resource if exists else null
     */
    public function getRelatedResourceReference(ResourceSet $sourceResourceSet,
    		$sourceEntityInstance,
    		ResourceSet $targetResourceSet,
    		ResourceProperty $targetProperty
    ) {
    	ODataException::createNotImplementedError($this->_message);
        $result = null;
    }
     /**
     * Serialize the mysql result array into Contacts objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeContact($result)
    {
        $contact = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $contact[] = $this->_serializeContacts($record);
        }

        return $contact;
    }

    /**
     * Serialize the mysql row into Contacts object
     * 
     * @param array $record each contacts row
     * 
     * @return Object
     */
    private function _serializeContacts($record)
    {
        $contacts = new Contacts();
        $contacts->id = $record['id'];
        $contacts->first_name = $record['first_name'];
        $contacts->last_name = $record['last_name'];
        $contacts->description = $record['description'];
        $contacts->department = $record['department'];
        $contacts->salutation = $record['salutation'];
        $contacts->created_by = $record['created_by'];
        $contacts->phone_home = $record['phone_home'];
        $contacts->phone_work = $record['phone_work'];
        $contacts->phone_other = $record['phone_other'];
        $contacts->primary_address_postalcode = $record['primary_address_postalcode'];
        $contacts->primary_address_state = $record['primary_address_state'];
        $contacts->assistant = $record['assistant'];
        $contacts->assistant_phone = $record['assistant_phone'];
        $contacts->phone_mobile = $record['phone_mobile'];
        $contacts->phone_fax = $record['phone_fax'];
        $contacts->primary_address_street = $record['primary_address_street'];
        $contacts->primary_address_city = $record['primary_address_city'];
        $contacts->primary_address_county = $record['primary_address_country'];
        
        if (!is_null($record['birthdate'])) {
            $dateTime = new DateTime($record['birthdate']);
            $contacts->birthdate = $dateTime->format('Y-m-d\TH:i:s');
        } else {
            $contacts->birthdate = null;
        }
        return $contacts;
    }
}
?>