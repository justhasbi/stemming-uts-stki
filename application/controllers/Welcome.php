<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('search/search');
	}
	
	public function upload()
	{
		$this->load->view('upload');
	}

	public function pdfreader()
	{
		$stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
		$stemmer  = $stemmerFactory->createStemmer();

		$reader = new \Asika\Pdf2text;

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'pdf';
		// $config['max_size']             = 100;
		// $config['max_width']            = 1024;
		// $config['max_height']           = 768;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('fupload'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
			// $this->load->view('upload_form', $error);
		}
		else
		{
			$fileName = $this->upload->data("full_path");
			$teks = $reader->decode($fileName);

			$insup['nama_file'] = $this->upload->data("file_name");
			$insup['deskripsi'] = $this->input->post('deskripsi');
			$insup['isi'] = $teks;
			$this->db->insert('upload',$insup);
			// echo $teks;
			// die();

			//hapus tanda baca
			$teks = str_replace("'", " ", $teks);
			$teks = str_replace("-", " ", $teks);
			$teks = str_replace(")", " ", $teks);
			$teks = str_replace("(", " ", $teks);
			$teks = str_replace("\"", " ", $teks);
			$teks = str_replace("/", " ", $teks);
			$teks = str_replace("=", " ", $teks);
			$teks = str_replace(".", " ", $teks);
			$teks = str_replace(",", " ", $teks);
			$teks = str_replace(":", " ", $teks);
			$teks = str_replace(";", " ", $teks);
			$teks = str_replace("!", " ", $teks);
			$teks = str_replace("?", " ", $teks); 
			$teks = str_replace(">", " ", $teks); 
			$teks = str_replace("<", " ", $teks); 

			//ubah ke huruf kecil 
			$teks = strtolower(trim($teks)); 

			$myArray = explode(" ", $teks); //proses tokenisasi

			$stopwords = array("ajak", "akan", "beliau", "khan", "lah", "dong", "ahh", "sob", "elo", "so", "kena", "kenapa", "yang", "dan", "tidak", "agak", "kata", "bilang", "sejak", "kagak", "cukup", "jua", "cuma", "hanya", "karena", "oleh", "lain", "setiap", "untuk", "dari", "dapat", "dapet", "sudah", "udah", "selesai", "punya", "belum", "boleh", "gue", "gua", "aku", "kamu", "dia", "mereka", "kami", "kita", "jika", "bila", "kalo", "kalau", "dalam", "nya", "atau", "seperti", "mungkin", "sering", "kerap", "acap", "harus", "banyak", "doang", "kemudian", "nyala", "mati", "milik", "juga", "mau", "dimana", "apa", "kapan", "kemana", "selama", "siapa", "mengapa", "dengan", "kalian", "bakal", "bakalan", "tentang", "setelah", "hadap", "semua", "hampir", "antara", "sebuah", "apapun", "sebagai", "di", "tapi", "lainnya", "bagaimana", "namun", "tetapi", "biar", "pun", "itu", "ini", "suka", "paling", "mari", "ayo", "barangkali", "mudah", "kali", "sangat", "banget", "disana", "disini", "terlalu", "lalu", "terus", "trus", "sungguh", "telah", "mana", "apanya", "ada", "adanya", "adalah", "adapun", "agaknya", "agar", "akankah", "akhirnya", "akulah", "amat", "amatlah", "anda", "andalah", "antar", "diantaranya", "antaranya", "diantara", "apaan", "apabila", "apakah", "apalagi", "apatah", "ataukah", "ataupun", "bagai", "bagaikan", "sebagainya", "bagaimanapun", "sebagaimana", "bagaimanakah", "bagi", "bahkan", "bahwa", "bahwasanya", "sebaliknya", "sebanyak", "beberapa", "seberapa", "begini", "beginian", "beginikah", "beginilah", "sebegini", "begitu", "begitukah", "begitulah", "begitupun", "sebegitu", "belumlah", "sebelum", "sebelumnya", "sebenarnya", "berapa", "berapakah", "berapalah", "berapapun", "betulkah", "sebetulnya", "biasa", "biasanya", "bilakah", "bisa", "bisakah", "sebisanya", "bolehkah", "bolehlah", "buat", "bukan", "bukankah", "bukanlah", "bukannya", "percuma", "dahulu", "daripada", "dekat", "demi", "demikian", "demikianlah", "sedemikian", "depan", "dialah", "dini", "diri", "dirinya", "terdiri", "dulu", "enggak", "enggaknya", "entah", "entahlah", "terhadap", "terhadapnya", "hal", "hanyalah", "haruslah", "harusnya", "seharusnya", "hendak", "hendaklah", "hendaknya", "hingga", "sehingga", "ia", "ialah", "ibarat", "ingin", "inginkah", "inginkan", "inikah", "inilah", "itukah", "itulah", "jangan", "jangankan", "janganlah", "jikalau", "justru", "kala", "kalaulah", "kalaupun", "kamilah", "kamulah", "kan", "kau", "kapankah", "kapanpun", "dikarenakan", "karenanya", "ke", "kecil", "kepada", "kepadanya", "ketika", "seketika", "khususnya", "kini", "kinilah", "kiranya", "sekiranya", "kitalah", "kok", "lagi", "lagian", "selagi", "melainkan", "selaku", "melalui", "lama", "lamanya", "selamanya", "lebih", "terlebih", "bermacam", "macam", "semacam", "maka", "makanya", "makin", "malah", "malahan", "mampu", "mampukah", "manakala", "manalagi", "masih", "masihkah", "semasih", "masing", "maupun", "semaunya", "memang", "merekalah", "meski", "meskipun", "semula", "mungkinkah", "nah", "nanti", "nantinya", "nyaris", "olehnya", "seorang", "seseorang", "pada", "padanya", "padahal", "sepanjang", "pantas", "sepantasnya", "sepantasnyalah", "para", "pasti", "pastilah", "per", "pernah", "pula", "merupakan", "rupanya", "serupa", "saat", "saatnya", "sesaat", "aja", "saja", "sajalah", "saling", "bersama", "sama", "sesama", "sambil", "sampai", "sana", "sangatlah", "saya", "sayalah", "se", "sebab", "sebabnya", "tersebut", "tersebutlah", "sedang", "sedangkan", "sedikit", "sedikitnya", "segala", "segalanya", "segera", "sesegera", "sejenak", "sekali", "sekalian", "sekalipun", "sesekali", "sekaligus", "sekarang", "sekitar", "sekitarnya", "sela", "selain", "selalu", "seluruh", "seluruhnya", "semakin", "sementara", "sempat", "semuanya", "sendiri", "sendirinya", "seolah", "sepertinya", "seringnya", "serta", "siapakah", "siapapun", "disinilah", "sini", "sinilah", "sesuatu", "sesuatunya", "suatu", "sesudah", "sesudahnya", "sudahkah", "sudahlah", "supaya", "tadi", "tadinya", "tak", "tanpa", "tentu", "tentulah", "tertentu", "seterusnya", "tiap", "setidaknya", "tidakkah", "tidaklah", "toh", "waduh", "wah", "wahai", "sewaktu", "walau", "walaupun", "wong", "yaitu", "yakni");

			$lengkap = array_diff($myArray, $stopwords); //remove stopword

			// print_r($filteredarray);
			foreach ($lengkap as $hasil) {
				// echo strlen($hasil)."<br>";
				// echo $hasil;
				if (strlen($hasil) >=4){
					$result = $stemmer->stem($hasil);
					// echo $result;
					// $this->load->library('database');
					$ins['nama_file'] = $this->upload->data("file_name");
					$ins['token'] = $hasil;
					$ins['tokenstem'] = $result;
					$this->db->insert('dokumen',$ins);
				}
			}
			echo ("<script LANGUAGE='JavaScript'>
			window.alert('Upload berhasil!');
			window.location.href='".base_url()."';
			</script>");
			// preproses($output,$fileName);
		}
	}

	public function search()
	{
		$katacari = $this->input->get('q');
		$sql = "SELECT DISTINCT nama_file,token,tokenstem,created_at FROM `dokumen` WHERE MATCH (token) AGAINST ('$katacari' IN BOOLEAN MODE) OR MATCH (tokenstem) AGAINST ('$katacari' IN BOOLEAN MODE)";
		// $sql = "SELECT DISTINCT nama_file,token,tokenstem (token,tokenstem)  AGAINST ('database' IN BOOLEAN MODE) AS score FROM dokumen";
		$data['data'] = $this->db->query($sql)->result_array();
		
		$this->load->view('search/searchlist',$data);

	}

	public function pembobotan()
	{	
		//hapus semua data
		$this->db->query("TRUNCATE TABLE tbindex");
		$data = $this->db->query("INSERT INTO `tbindex`(`Term`, `DocId`, `Count`) SELECT `token`,`nama_file`,count(*) FROM `dokumen` group by `nama_file`,token");
		
		$jumlah_doc = $this->db->query("SELECT DISTINCT DocId FROM tbindex")->result_array();
		$n = count($jumlah_doc);
		//ambil data index
		$dataIndex = $this->db->query("SELECT * FROM tbindex ORDER BY Id")->result_array();
		//proses pembobotan
		foreach ($dataIndex as $val) {
			//$w = tf * log (n/N)
			$term = $val['Term'];		
			$tf = $val['Count'];
			$id = $val['Id'];
			
			//berapa jumlah dokumen yang mengandung term tersebut?, N
			
			$rowNTerm = $this->db->query("SELECT Count(*) as N FROM tbindex WHERE Term = '$term'")->row_array();
			$NTerm = $rowNTerm['N'];
			
			$w = $tf * log($n/$NTerm);
			
			//update bobot dari term tersebut
			// $resUpdateBobot = mysql_query("UPDATE tbindex SET Bobot = $w WHERE Id = $id");		
			$this->db->update('tbindex',array('Bobot'=>$w),array('Id'=>$id));
		} 

		$this->db->query("TRUNCATE TABLE tbvektor");
		// mysql_query("TRUNCATE TABLE tbvektor");
		//ambil setiap DocId dalam tbindex
			//hitung panjang vektor untuk setiap DocId tersebut
			//simpan ke dalam tabel tbvektor	
			$dataVektor = $this->db->query("SELECT DISTINCT DocId FROM tbindex")->result_array();
			print("Terdapat " . count($dataVektor) . " dokumen yang dihitung panjang vektornya. <br />");
			
			foreach ($dataVektor as $dv) {
				$docId = $dv['DocId'];
			
				$rowVektor = $this->db->query("SELECT Bobot FROM tbindex WHERE DocId = '$docId'")->result_array();
				//jumlahkan semua bobot kuadrat 
				$panjangVektor = 0;		
				foreach ($rowVektor as $rv) {
					$panjangVektor = $panjangVektor + $rv['Bobot']  *  $rv['Bobot'];	
				}
				
				//hitung akarnya		
				$panjangVektor = sqrt($panjangVektor);
				
				//masukkan ke dalam tbvektor		
				// $resInsertVektor = mysql_query("INSERT INTO tbvektor (DocId, Panjang) VALUES ('$docId', $panjangVektor)");	
				$this->db->insert('tbvektor',array('DocId'=>"$docId",'Panjang'=>$panjangVektor));
			} //end while $rowDocId

		echo "<pre>";
		print_r($jumlah_doc);
		echo "</pre>";
	}

	public function vektor()
	{
		$this->load->helper('My_helper');
		$item1='praktikum';
		$item2='praktikum';
		echo "Hasil hitung".getSimilarityCoefficient( $item1, $item2 );
	}
}
