<?php

require_once dirname(__FILE__) . '/base/MC_Rest.php';

class MC_Lists extends MC_Rest
{

    function MC_Lists($api_key)
    {
        $this->name = 'lists';

        parent::__construct($api_key);
    }

    function addMember($list = '', $subscriber = null)
    {
        $this->request = $list. '/members';
        return $this->execute('POST', json_encode($subscriber));
    }
    
	function mergeFields($list = '')
	{
		$this->request = $list.'/merge-fields/';

		return $this->execute( 'GET' );
	}

}

?>