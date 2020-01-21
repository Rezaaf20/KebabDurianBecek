<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// make sure you include this header to your function
// header('Content-Type: application/json');

class Pembeli extends MY_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    $this->load->model("Dbs");
  }

  function index()
  {
    echo "API DOCS!";
  }

  function get_pembeli(){
    header('Content-Type: application/json');
      //StartPagination
      if(isset($_GET['page'])){//cek parameter page
        $page=$_GET['page'];
      }else{
        $page=1;//default jika parameter page tidak diload
      }
      $limitDb=9;
      $offsetDb=0;
      if($page!=1 and $page!=0){
        $offsetDb=$limitDb*($page-1);
      }
      //End Pagination
      //default fungsi dari : getdata($table,$where=null,$limit=9,$offset=0){
      $table='pembeli';
      $loadDb=$this->Dbs->getdata($table,null,$limitDb,$offsetDb);//database yang akan di load
      $check=$loadDb->num_rows();
      if($check>0){
        // $get=$loadDb->result(); //Uncomment ini untuk contoh
        $data=array(
          'status'=>'success',
          'message'=>'found',
          'total_result'=>$check,
          'results'=>$loadDb->result(),
        );
      }else{
        $data=array(
          'status'=>'success',
          'total_result'=>$check,
          'message'=>'not found'
        );
      }
    $json=json_encode($data);
    echo $json;
  }

  function update_pembeli()
  {
    header('Content-Type: application/json');
      //default fungsi dari : getdata($table,$where=null,$limit=9,$offset=0){
      $data = array(
        'id_pembeli' => $this->input->get('id_pembeli',TRUE),
        'nama_pembeli' => $this->input->get('nama_pembeli',TRUE),
        'jk' => $this->input->get('jk',TRUE),
        'no_telp' => $this->input->get('no_telp',TRUE),
        'alamat' => $this->input->get('alamat',TRUE),
      );

      $table='pembeli';
      $loadDb=$this->Dbs->update($data,$table,"id_pembeli",$this->input->get('id_pembeli'));
      if($loadDb){
        // $get=$loadDb->result(); //Uncomment ini untuk contoh
        $data=array(
          'status'=>'success',
          'message'=>'Update Success',
          'total_result'=>1,
          // 'results'=>$get //Uncomment ini untuk contoh
        );
      }else{
        $data=array(
          'status'=>'Failed',
          'total_result'=>0,
          'message'=>'not found'
        );
      }

    $json=json_encode($data);
    echo $json;
  }
  //
  function delete_pembeli()
  {
    header('Content-Type: application/json');
      $table='pembeli';
      $loadDb=$this->Dbs->delete("id_pembeli",$this->input->get('id_pembeli'),$table);
      if($loadDb){
        // $get=$loadDb->result(); //Uncomment ini untuk contoh
        $data=array(
          'status'=>'success',
          'message'=>'Delete Success',
          'total_result'=>1,
          // 'results'=>$get //Uncomment ini untuk contoh
        );
      }else{
        $data=array(
          'status'=>'success',
          'message'=>'Delete Success',
          'total_result'=>1,
        );
      }

    $json=json_encode($data);
    echo $json;
  }
}
