<?php
header("Content-type: application/json");
header("Content-type: text/json; charset=utf-8");

$db     = db::singleton();
$json   = json::singleton();

db::init('host', 'port', 'db', 'user', 'pass');

switch ($_GET['mode'])
{
    case 'judete':
        $data = db::a("select jud.jud_code, initcap(jud_lbl) jud_lbl, minx, miny, maxx , maxy  from (select jud_code, jud_lbl,ST_XMin(the_geom) as minx, ST_YMin(the_geom) as miny, ST_XMax(the_geom)  As maxx,  ST_YMax(the_geom)  As maxy from ro_judete union select 'AA','All Counties', 0.0, 0.0, 0.0, 0.0) jud order by jud.jud_code asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'map_search_location':
        $data = db::a("select out_uat_name, out_jud_name,out_x, out_y from get_uat('".$_GET['name_startsWith']."') LIMIT 20");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid,count(partid) as nr_primari from ro_uat_primari_2012 group by id_partid,partid union select 0,' All Political Organisations',9999) par order by par.nr_primari desc, par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide_deputati_2008':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid from ro_deputati_2008 group by id_partid,partid union select 0,' All Political Organisations') par order by par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
    case 'partide_senat_2008':
        $data = db::a("select par.id_partid, initcap(par.partid) partid  from (select id_partid, partid from ro_senatori_2008 group by id_partid,partid union select 0,' All Political Organisations') par order by par.partid asc");
        $output = json::generate($data, 'data', $_GET['callback']);
        break;
}
echo $output;


class json
{
    private static $instance;

    public static function singleton()
    {
        if (!isset(self::$instance))
        {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }
        return self::$instance;
    }
    
    function generate($data, $root='data', $callback=false)
    {
        $output = '';
        if ($callback != false) { $output = $callback."("; }
        $output .= json_encode(array(
            $root => $data
        ));
        if ($callback != false) { $output .= ");"; }
        
        return $output;
    }
}

class db
{
    private static $instance;

    public static function singleton()
    {
        if (!isset(self::$instance))
        {
            $obj = __CLASS__;
            self::$instance = new $obj;
        }
        return self::$instance;
    }
    
    public  static $errors;
    private static $connected = false;
    
    function init($host, $port, $db, $user, $pass)
    {
        $constring = 'host='.$host.' port='.$port.' dbname='.$db.' user='.$user.'  password='.$pass;
        
        $link = pg_connect ($constring); 
		if (!$link)
        { 
			die('Error: Could not connect: ' . pg_last_error());
		}
        
        self::$connected = true;
        
        return true;
    }
    // afiseaza query
    function eecho($query)
    {
        echo $query;
        return true;
    }
    
    
    // citeste toate rezultatele din query
    function a($query, $identif_string="")
    {
        $return = array();
        
        if (strlen($query) > 0)
        {
            // Check cached results
            $cache = cache::exists($query);
            if ($cache) { return $cache; }
            
            // Query the database
            $result = self::q($query);
            
            if ($result)
            {
                while ($row = pg_fetch_row($result))
                {
                    $output = array();
                    
                    if (is_array($row))
                    {
                        $i = 0;
                        foreach($row as $element)
                        {
                            //echo pg_field_type($result, $i) . "<br>\n";
                            if (substr(pg_field_type($result, $i), 0, 1) == '_')
                            {
                                $element = explode(",", substr($element, 1, -1));
                                
                                $output[pg_field_name($result, $i)] = $element;
                            }
                            else
                            {   
                                if (pg_field_type($result, $i)=='numeric')
                                {
                                    $fieldname = pg_field_name($result, $i);
                                    
                                    switch ($fieldname)
                                    {
                                        case 'cnp':
                                        case 'age':
                                        case 'identity_card_no':
                                        case 'registration_no':
                                            $output[pg_field_name($result, $i)] = $element;
                                            break;
                                        default:
                                            $output[pg_field_name($result, $i)] = floatval($element);
                                            break;
                                    }
                                    
                                }
                                else $output[pg_field_name($result, $i)] = $element;
                            }
                            
                            $i++;
                        }
                    }
                    
                    if (strlen($identif_string) > 0 && strlen($output[$identif_string]) > 0)
                    {
                        $return[$output[$identif_string]] = $output;
                    }
                    else
                    {
                        $return[] = $output;
                    }
                }
                
                cache::update($query, $return);
            }
        }
        return $return;
    }
    
    // returneaza primul rezultat dintr-un query executat
    function aq($query)
    {
        $result = self::a($query);
        return $result[0];
    }
    
    
    // executa query
    function q($query)
    {
        if (strlen($query) > 0)
        {
            if (self::$connected == false) { self::init(); }
            
            $result = pg_query($query);        
            return $result;
        }
        
        return false;
    }
    // returneaza numarul de rezultate
    function nr($query)
    {
        // Check cached results
        $cache = cache::exists($query);
        if ($cache) { return $cache; }
        
        if (self::$connected == false) { self::init(); }
        
        $counted = 0;
        
        $resultCount = pg_query($query);
        if ($resultCount)
        {
            while ($row = pg_fetch_row($resultCount)) { 
                $counted = $row[0];
            }
            pg_free_result($resultCount);
        }
        
        cache::update($query, $counted);
        
        return $counted;
    }
    // foloseste o functie de scriere si returneaza $row[0]
    function ins($q)
    {
        if (self::$connected == false) { self::init(); }
        
        $result = pg_query($q);
        $row = pg_fetch_row($result);
        if (!$result)
        {
            self::$errors[] = pg_last_error();
            $return = false;
        }
        else
        {
            $return = $row[0];
        }
        
        return $return;
    }
    // sterge un anumit row din baza de date cu functie
    function del($q)
    {
        if (self::$connected == false) { self::init(); }
        
        $result = pg_query($q);
        if (!$result)
        {
            self::$errors[] = pg_last_error();
            $return = false;
        }
        else
        {
            $return = true;
        }
        
        return $return;
    }
    
    
    
    // field-urile unui select, daca exista rezultate
    function fields($query)
    {
        $return = array();
        if (strlen($query) > 0)
        {
            $result = self::q($query);
            
            if ($result)
            {
                $row = pg_fetch_row($result);
                
                for ($i=0; $i < pg_num_fields($result); $i++)
                {
                    $return[pg_field_name($result, $i)] = pg_field_type($result, $i);
                }
                
                pg_free_result($result);
            }
        }
        return $return;
    }
    
    // returneaza numele campului si tipul pentru un anumit table sau view
    function head($select)
    {
        $r = self::a("SELECT a.attnum, a.attname AS field, t.typname AS type FROM pg_class c, pg_attribute a, pg_type t WHERE c.relname = '".$select."' and a.attnum > 0 and a.attrelid = c.oid and a.atttypid = t.oid ORDER BY a.attnum");
        foreach ($r as $key=>$value)
        {
            $array[$value['field']] = $value['type'];
        }
        
        return $array;
    }
}
?>