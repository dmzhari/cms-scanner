<?php
//error_reporting(0);
define("wp","\e[32m");
define("joomla","\e[96m");
define("lokomedia","\e[93m");
define("drupal","\e[95m");
define("vbulletin","\e[35m");
define("live","\e[35m");
define("file","\e[90m");
define("notfound","\e[31m");
define("note","\e[36m");
define("author","\e[92m");
define("chose","\e[94m");
define("chose2","\e[33m");
	class CMS{
		public function curl($url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			//curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
			$exe = curl_exec($curl);
			curl_close($curl);
			return $exe;
		}
		public function Save($save,$name){
			$result = fopen($name, "a+");
			fwrite($result,"$save\n");
			fclose($result);
		}
		public function Scann_CMS($url){
			$web = "http://".$url;
			$site = $this->curl($web);
			for ($i=0; $i < $site; $i++);
			if (preg_match("/\/wp-login.php\/|\/wp-content\/|\/wp-includes\/|\/xmlrpc.php/",$site)) {
				echo wp."this site is Wordpress => $web\n";
				$this->Save($url,"Wordpress.txt");
			}
			else if(preg_match("/\/administrator\/|\/components\/|\/com_tags\/|\/<script type=\"text\/javascript\" src=\"\/media\/system\/js\/mootools.js\"><\/script>|Joomla|\/media\/system\/js\/|mootools-core.js|com_content|Joomla!/", $site)){
				echo joomla."this site is Joomla => $web\n";
				$this->Save($url,"Joomla.txt");
			}
			else if(preg_match("/\/Drupal|drupal|sites\/all|drupal.org/", $site)){
				echo drupal."this site is Drupal => $web\n";
				$this->Save($url,"Drupal.txt");
			}
			else if(preg_match("/\/faq.php\/vb|\/clientscript\/|vBulletin\/|\/vbulletin/", $site)){
				echo vbulletin."this site is vBulletin => $web\n";
				$this->Save($url,"vBulletin.txt");
			}
			else if(preg_match("/\/skin\/frontend\/base\/default\/|\/\/magentocore.net\/mage\/mage.js|\/webforms\/index\/index\/|\/customer\/account\/login/", $site)){
				echo magento."this site is Magento => $web\n";
				$this->Save($url,"Magento.txt");
			}
			else if(preg_match("/\/route=product|OpenCart|route=common|catalog\/view\/theme/", $site)){
				echo opencart."this site is OpenCart => $web\n";
				$this->Save($url,"OpenCart.txt");
			}
			else if(preg_match("/\/semua-agenda.html|foto_banner\/|lokomedia/", $site)){
				echo lokomedia."this site is Lokomedia => $web\n";
				$this->Save($url,"Lokomedia.txt");
			}
			else if(preg_match("/\/filemanager.php|filemanager|fileman|\/assets\/global\/plugins\/|\/assets\/plugins\/|\/assets\/public\/plugins\/|\/assets\/private\/plugins\/|\/assets\/admin|\/admin\/plugins\/|assets\/dashboard\//", $site)){
				echo file."this site is have Filemanager Source => $web\n";
				$this->Save($url,"Filemanager.txt");
			}
			else if(preg_match("/\/mcc.godaddy.com\/park\/|domain has expired|Domain Expired|domain expired|Undermainteance|mcc.godaddy.com|Under Construction|Construction|expired/", $site)){
				echo notfound."this site is Expired => $web\n";
				$this->Save($url,"Expired.txt");
			}
			else if(preg_match("/html|head|body/", $site)){
				echo live."this site is live but unknown CMS => $web\n";
				$this->Save($url,"LiveUnknown.txt");
			}
			else {
			echo notfound."Unknown => $web\n";
			$this->Save($url,"Unknown.txt");
			}
		}
		public function Mass_Scan($list){
			if(!file_exists($list)) die("File List ".$list." Not Found");
			$domain =  explode("\n", file_get_contents($list));
			foreach ($domain as $web) {
				$this->Scann_CMS($web);
			}
		}
		public function Chose(){
			echo author."\n[#] Author ./EcchiExploit [#]\n";
			echo note."Note : Don't Change http:// Or https:// !!!\n\n";
			echo chose2."\t\t1. Mass Scan CMS\n";
			echo chose2."\t\t2. Not Mass Scan CMS\n";
			echo chose."\nYour Chose => ";
			$pilih = trim(fgets(STDIN));
			switch ($pilih) {
				case '1':
					echo "\tYour List site => ";
					$list = trim(fgets(STDIN));
					$this->Mass_Scan($list);
					break;
				case '2':
					echo "\tYour Site => ";
					$url = trim(fgets(STDIN));
					$this->Scann_CMS($url);
					break;
				default:
					echo "Fuck You!!\n";
					break;
			}
		}
	}
	$scan = new CMS();
	$scan->Chose();
?>