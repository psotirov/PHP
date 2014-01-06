<h4>SITEMAP</h4><ul style="margin-left:15%;font-size:large">
<?PHP 
	for ($p=0;$p<count($sitemap[$lang]);$p++)
	{
		print '<li><a href="';
		create_link(($p+1),0,0,-1);
		print '">';
		if (is_array($sitemap[$lang][$p]))
		{
			print $sitemap[$lang][$p][0].'</a></li><ul style="margin-left:15%">';
			for ($s=1;$s<count($sitemap[$lang][$p]);$s++)
			{
				print '<li><a href="';
				create_link(($p+1),$s,0,-1);
				print '">';
				if (is_array($sitemap[$lang][$p][$s]))
				{
					print $sitemap[$lang][$p][$s][0].'</a></li><ul style="margin-left:15%">';
					for ($i=1;$i<count($sitemap[$lang][$p][$s]);$i++)
					{
						print '<li><a href="';
						create_link(($p+1),$s,$i,-1);
						print '">'.$sitemap[$lang][$p][$s][$i].'</a></li>';
					}
					print '</ul>';
				} else print $sitemap[$lang][$p][$s].'</a></li>';
			}
			print '</ul>';
		} else print $sitemap[$lang][$p].'</a></li>';
	}
?></ul>
