<?php
//Copyright (C) 2012  PoliticalColours.ro - Project of TheSponge.eu Some Rights Reserved.
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU General Public License as published by
//  the Free Software Foundation, either version 3 of the License, or
//  (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU General Public License for more details.
//
//  You should have received a copy of the GNU General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.

class pagination
{
    public $pages;
    
    function pagination()
    {
        $this->pages = 3;
    }
	
	function navpag($total, $page, $rows, $link, $pagename='page')
	{  
		$pages = $this->pages;
		$html = '';
		
		// set a value to $page, if not numeric
		if (!is_numeric($page)) { $page = '1'; }
		
		if ($total > $rows)
		{
			$output = array();
			
			$nrpages = ceil ($total/$rows);
			$min = ($page - 1) * $rows; if ($min == 0) { $min = 1; }
			$max = $page * $rows; if ($max > $total) { $max = $total; }
			
            if (stristr($link, '?'))
            {
                $parts = explode('?', $link);
                
                for ($i=1; $i<=$nrpages; $i++)
                {
                    if ($i <= ($page - $pages) || $i >= ($page + $pages))
                    {
                        if ($i == 1)
                        {
                            // first
                            $output['first'] = array(
                                'name'=>'Prima pagina',
                                //'link'=>elink($parts[0].'/'.$pagename.'-'.$i.'?'.$parts[1]),
                                'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $i ,
                                'class'=>'box'
                            );
                        }
                        if ( $i == $nrpages )
                        {
                            // last
                            $output['last'] = array(
                                'name'=>'Ultima pagina',
                                //'link'=>elink($parts[0].'/'.$pagename.'-'.$i.'?'.$parts[1]),
                                'link'=>conf::val('site_url') .  $parts[0] . '?' . $pagename . '='.  $i ,
                                'class'=>'box'
                            );
                        }
                    }
                    
                    if ( $page > 1)
                    {
                        $prevpage = $page - 1;
                        $output['prev'] = array(
                            'name'=>'&laquo;',
                            //'link'=>elink($parts[0].'/'.$pagename.'-'.$prevpage.'?'.$parts[1]),
                            'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $prevpage ,
                            'class'=>'free'
                        );
                    }
                    if ( $i <= ($page + $pages) && $i >= ($page - $pages) )
                    {
                        if ( $page == $i )
                        {
                            $output['pages'][] = array(
                                'name'=>$i,
                                'class'=>'active'
                            );
                        }
                        else
                        {
                            $output['pages'][] = array(
                                'name'=>$i,
                                //'link'=>elink($parts[0].'/'.$pagename.'-'.$i.'?'.$parts[1]),
                                'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $i ,
                                'class'=>'box'
                            );
                        }
                    }
                    if ( $page < $nrpages)
                    {
                        $nextpage = $page + 1;
                        $output['next'] = array(
                            'name'=>'&raquo;',
                            //'link'=>elink($parts[0].'/'.$pagename.'-'.$nextpage.'?'.$parts[1]),
                            'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $nextpage ,
                            'class'=>'free'
                        );
                    }
                }
            }
            else
            {
                for ($i=1; $i<=$nrpages; $i++)
                {
                    if ($i <= ($page - $pages) || $i >= ($page + $pages))
                    {
                        if ($i == 1)
                        {
                            // first
                            $output['first'] = array(
                                'name'=>'Prima pagina',
                                // 'link'=>elink($link.'/'.$pagename.'-'.$i),
                                'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $i ,
                                'class'=>'box'
                            );
                        }
                        if ( $i == $nrpages )
                        {
                            // last
                            $output['last'] = array(
                                'name'=>'Ultima pagina',
                                // 'link'=>elink($link.'/'.$pagename.'-'.$i),
                                'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $i ,
                                'class'=>'box'
                            );
                        }
                    }
                    
                    if ( $page > 1)
                    {
                        $prevpage = $page - 1;
                        $output['prev'] = array(
                            'name'=>'&laquo;',
                            // 'link'=>elink($link.'/'.$pagename.'-'.$prevpage),
                            'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $prevpage ,
                            'class'=>'free'
                        );
                    }
                    if ( $i <= ($page + $pages) && $i >= ($page - $pages) )
                    {
                        if ( $page == $i )
                        {
                            $output['pages'][] = array(
                                'name'=>$i,
                                'class'=>'active'
                            );
                        }
                        else
                        {
                            $output['pages'][] = array(
                                'name'=>$i,
                                // 'link'=>elink($link.'/'.$pagename.'-'.$i),
                                'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $i ,
                                'class'=>'box'
                            );
                        }
                    }
                    if ( $page < $nrpages)
                    {
                        $nextpage = $page + 1;
                        $output['next'] = array(
                            'name'=>'&raquo;',
                            // 'link'=>elink($link.'/'.$pagename.'-'.$nextpage),
                            'link'=>conf::val('site_url') . $parts[0] . '?' . $pagename . '='. $nextpage ,
                            'class'=>'free'
                        );
                    }
                }
            }
            
            
            
            
			// alter the structure of $output
			$data = array();
            
			if (is_array($output['first']))
			{
				$data['pages'][] = $output['first'];
			}
			// show prev
			if (is_array($output['prev']))
			{
				$data['pages'][] = $output['prev'];
			}
			// show pages
			if (is_array($output['pages']))
			{
				foreach ($output['pages'] as $key=>$item)
				{
					$data['pages'][] = $item;
				}
			}
			// show next
			if (is_array($output['next']))
			{
				$data['pages'][] = $output['next'];
			}
			// show last
			if (is_array($output['last']))
			{
				$data['pages'][] = $output['last'];
			}
		}
		return $data;
	}
}
?>