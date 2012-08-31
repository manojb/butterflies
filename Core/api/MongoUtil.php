<?php
class MongoUtil
{
  
    /**
     * Less than.
     */
    const LT = '$lt';

    /**
     * Less than or equal to.
     */
    const LTE = '$lte';

    /**
     * Greater than.
     */
    const GT = '$gt';

    /**
     * Greater than or equal to.
     */
    const GTE = '$gte';

    /**
     * Checks for a field in an object.
     */
    const IN = '$in';

    /**
     * Not equal.
     */
    const NE = '$ne';


    /**
     * Sort ascending.
     */
    const ASC = 1;

    /**
     * Sort descending.
     */
    const DESC = -1;


    /**
     * Function as binary data.
     */
    const BIN_FUNCTION = 1;

    /**
     * Default binary type: an arrray of binary data.
     */
    const BIN_ARRAY = 2;

    /**
     * Universal unique id.
     */
    const BIN_UUID = 3;

    /**
     * Binary MD5.
     */
    const BIN_MD5 = 5;

    /**
     * User-defined binary type.
     */
    const BIN_CUSTOM = 128;


    /* Command collection */
    protected static $CMD = '.$cmd';

    /* Admin database */
    const ADMIN = "admin";

    /* Commands */
    const AUTHENTICATE      = "authenticate";
    const CREATE_COLLECTION = "create";
    const DELETE_INDICES    = "deleteIndexes";
    const DROP              = "drop";
    const DROP_DATABASE     = "dropDatabase";
    const FORCE_ERROR       = "forceerror";
    const INDEX_INFO        = "cursorInfo";
    const LAST_ERROR        = "getlasterror";
    const LIST_DATABASES    = "listDatabases";
    const LOGGING           = "opLogging";
    const LOGOUT            = "logout";
    const NONCE             = "getnonce";
    const PREV_ERROR        = "getpreverror";
    const PROFILE           = "profile";
    const QUERY_TRACING     = "queryTraceLevel";
    const REPAIR_DATABASE   = "repairDatabase";
    const RESET_ERROR       = "reseterror";
    const SHUTDOWN          = "shutdown";
    const TRACING           = "traceAll";
    const VALIDATE          = "validate";

}