<?php

/* */

Class mysql
{

    public $query;
    public $data;
    public $result;
    public $rows;
	public $page = 0;
	public $perpage = 10;
	public $current = 1;
	public $url;
	public $link = '';
	public $total = '';
	public $pagination = false;

    protected $config;
    protected $host;
    protected $port;
    protected $user;
    protected $pass;
    protected $dbname;
    protected $con;



    public function __construct()
    {
        try
        {
            #array com dados do banco
            include 'database.conf.php';
            global $databases;
            $this->config = $databases['local'];
            # Recupera os dados de conexao do config
            $this->dbname = $this->config['dbname'];
            $this->host = $this->config['host'];
            $this->port = $this->config['port'];
            $this->user = $this->config['user'];
            $this->pass = $this->config['password'];
            # instancia e retorna objeto
            $this->con = mysql_connect( "$this->host", "$this->user", "$this->pass" );
            mysql_select_db( "$this->dbname" );
            if ( !$this->con )
            {
                throw new Exception( "Falha na conexão MySql com o banco [$this->dbname] em database.conf.php" );
            }
            else
            {
                return $this->con;
            }
			$this->url = $_SERVER['SCRIPT_NAME'];
        }
        catch ( Exception $e )
        {
            echo $e->getMessage();
            exit;
        }
        return $this;
    }

    public function query( $query = '' )
    {
        try
        {
            if ( $query == '' )
            {
                throw new Exception( 'mysql query: A query deve ser informada como parametro do método.' );
            }
            else
            {
                $this->query = $query;
				if($this->pagination == true){
					$this->result = mysql_query( $this->query );
					$this->fetchAll();
					$this->paginateLink();
					$this->query .= " LIMIT $this->page, $this->perpage";
					$this->pagination = false;
				}
                $this->result = mysql_query( $this->query );
            }
        }
        catch ( Exception $e )
        {
            echo $e->getMessage();
            exit;
        }
        return $this;
    }

    public function fetchAll()
    {
        $this->data = "";
        $this->rows = 0;
        while ( $row = mysql_fetch_array( $this->result, MYSQL_ASSOC ) )
        {
            $this->data[] = $row;
        }
        if ( isset( $this->data[0] ) )
        {
            $this->rows = count( $this->data );
        }
        return $this->data;
    }

    public function rowCount()
    {
        return @mysql_affected_rows();
    }

	public function getUrl($perpage)
	{
		$this->url = $_SERVER['REQUEST_URI'];
		return $this;
	}
	public function paginate($perpage)
	{
		$this->pagination = true;
		$this->perpage = $perpage;
		return $this;
	}
	public function paginateLink()
    {
		if(!preg_match('/\?/',$this->url))
		{
			$this->url .= "?";
		}else{
			$this->url .= "&";
		}
		if ( isset( $_GET['page'] ) )
		{
			$this->current = $_GET['page'];
			$this->page = $this->perpage * $_GET['page'] - $this->perpage;
			if ( $_GET['page'] == 1 )
			{
				$this->page = 0;
			}
		}
		$this->total = $this->rows;
		if ( $this->rows > $this->perpage )
		{
			$this->link = "<div ><ul class=\"pagination pagination-sm\">";
			$prox = "javascript:;";
			$ant = "javascript:;";
			if ( $this->current >= 2 )
			{
				$ant = $this->url."page=" . ($this->current - 1);
			}
			if ( $this->current >= 1 && $this->current < ($this->total / $this->perpage))
			{
				$prox = $this->url."page=" . ($this->current + 1);
			}
			$this->link .= '<li class=\"page-item\"><a href="' . $ant . '">&laquo;</a></li>';
			$from = round( $this->total / $this->perpage );
			if($from == 1){$from++;}

			for ( $i = 1; $i <= $from ; $i++ )
			{
				if ( $this->current == $i )
				{
					$this->link .= "<li class=\"page-item\"><a>$i</a></li>\n";
				}
				else
				{
					$this->link .= "<li class=\"page-item\"><a href=\"".$this->url."page=$i\">$i</a></li>\n";
				}
			}
			$this->link .= '<li class=\"page-item\"><a href="' . $prox . '">&raquo;</a></li>';
			$this->link .= "</ul>\n";
			$this->link .= "</div>\n";
		}
		return $this;
    }

    public function cut($str,$chars,$info=  '')
    {
        if ( strlen( $str ) >= $chars )
        {
            $str = preg_replace( '/\s\s+/', ' ', $str );
            $str = strip_tags( $str );
            $str = preg_replace( '/\s\s+/', ' ', $str );
            $str = substr( $str, 0, $chars );
            $str = preg_replace( '/\s\s+/', ' ', $str );
            $arr = explode( ' ', $str );
            array_pop( $arr );

            $final = implode( ' ', $arr ) . $info;
        }
        else
        {
            $final = $str;
        }
        return $final;
    }

}
?>
