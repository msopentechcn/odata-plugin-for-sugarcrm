<?php
/** 
 * Implementation of IDataServiceMetadataProvider.
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
use ODataProducer\Providers\Metadata\ResourceStreamInfo;
use ODataProducer\Providers\Metadata\ResourceAssociationSetEnd;
use ODataProducer\Providers\Metadata\ResourceAssociationSet;
use ODataProducer\Common\NotImplementedException;
use ODataProducer\Providers\Metadata\Type\EdmPrimitiveType;
use ODataProducer\Providers\Metadata\ResourceSet;
use ODataProducer\Providers\Metadata\ResourcePropertyKind;
use ODataProducer\Providers\Metadata\ResourceProperty;
use ODataProducer\Providers\Metadata\ResourceTypeKind;
use ODataProducer\Providers\Metadata\ResourceType;
use ODataProducer\Common\InvalidOperationException;
use ODataProducer\Providers\Metadata\IDataServiceMetadataProvider;
use ODataProducer\Providers\Metadata\ServiceBaseMetadata;
use ODataProducer\Providers\Metadata\MetadataMapping;

//Begin Resource Classes

/**
 * Post entity type.
 * 
 * @category  Service
 * @package   SugarCRM
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   Release: 1.0
 * @link      http://odataphpproducer.codeplex.com
 */
require_once 'newclass.php';
include "../../../../../config.php";

        
/** The name of the database for SugarCRM */
define('DB_NAME', $sugar_config['dbconfig']['db_name']);

/** MySQL database username */
define('DB_USER', $sugar_config['dbconfig']['db_user_name']);

/** MySQL database password */
define('DB_PASSWORD', $sugar_config['dbconfig']['db_password']);

/** MySQL hostname */
define('DB_HOST', $sugar_config['dbconfig']['db_host_name']);

//End Resource Classes


/**
 * Create SugarCRM metadata.
 * 
 * @category  Service
 * @package   SugarCRM
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   Release: 1.0
 * @link      http://odataphpproducer.codeplex.com
 */
class CreateSugarCRMMetadata
{

  private static $_entityMapping = array();

    /**
     * create metadata
     * 
     * @throws InvalidOperationException
     * 
     * @return NorthWindMetadata
     */
    public static function create()
    {
        $metadata = new ServiceBaseMetadata('SugarCRMEntities', 'SugarCRM');
        
        //generate metadata
        $metadata = self::generateMetadata($metadata);

        return $metadata;
    }

    public static function getEntityMapping() {
      if (!is_null(self::$_entityMapping))
      {
        self::$_entityMapping = array (
            'Contacts' => array (
                '$MappedTable$' => 'Contacts',
                'ID' => 'id',
                'FirstName' => 'first_name',
                'LastName' => 'last_name',
                'Description' => 'description',
                'Department' => 'department',
                'Salutation' => 'salutation',
                'CreatedBy' => 'created_by',
                'PhoneHome' => 'phone_home',
                'PhoneWork' => 'phone_work',
                'PhoneOther' => 'phone_other',
                'PrimaryAddressPostalcode' => 'primary_address_postalcode',
                'PrimaryAddressState' => 'primary_address_state',
                'Assistant' => 'assistant',
                'AssistantPhone' => 'assistant_phone',
                'PrimaryAddressStreet' => 'primary_address_street',
                'PrimaryAddressCity' => 'primary_address_city',
                'PrimaryAddressCountry' => 'primary_address_country',
                'PhoneMobile' => 'phone_mobile',
                'PhoneFax' => 'phone_fax',
                'Birthdate' => 'birthdate'
              )
          );
      }
      
      return self::$_entityMapping;
    }
    
    public static function generateMetadata($metadata) {
        $link = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, true) or die(print_r(mysql_error(), true));
        mysql_select_db(DB_NAME, $link);
        $sql = "select name from suga_sugarodata where deleted =0 order by date_entered asc";
        $res = mysql_query($sql);
        $tables = array();
        if(!$res){
            return $metadata;
        }
        while ($record = mysql_fetch_array($res, MYSQL_ASSOC)) {
            //get odata tables
            $tables[] = $record['name'];
        }
        
        foreach ($tables as $k => $v) {
            $var = ucfirst($v).'EntityType';
            $$var = $metadata->addEntityType(new ReflectionClass(ucfirst($v)), ucfirst($v), 'SugarCRM');
            
                $sqlt = "desc " . $v;
                $rest = mysql_query($sqlt);
                $k = 0;
                while ($rect = mysql_fetch_array($rest, MYSQL_ASSOC)) {
                    if($k == 0) {
                        $metadata->addKeyProperty($$var, $rect['Field'], EdmPrimitiveType::STRING);
                    } else {
                        if(in_array(strstr($rect['Type'], '(', true), array('char', 'varchar', 'text')) ) {
                            $metadata->addPrimitiveProperty($$var, $rect['Field'], EdmPrimitiveType::STRING);
                        }
                        if(in_array(strstr($rect['Type'], '(', true), array('int')) ) {
                            $metadata->addPrimitiveProperty($$var, $rect['Field'], EdmPrimitiveType::INT32);
                        }
                        if(in_array(strstr($rect['Type'], '(', true), array('tinyint')) ) {
                            $metadata->addPrimitiveProperty($$var, $rect['Field'], EdmPrimitiveType::INT16);
                        }                    
                        if(in_array(strstr($rect['Type'], '(', true), array('date', 'datetime')) ) {
                            $metadata->addPrimitiveProperty($$var, $rect['Field'], EdmPrimitiveType::DATETIME);
                        }
                    }
                    $k++;
                }
                
            $metadata->addResourceSet(ucfirst($v), $$var);
        }
        return $metadata;
    }
       
}