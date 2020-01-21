<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Transaksi extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Transaksi_model');
            $this->load->library('form_validation');
	    $method=$this->router->fetch_method();
            // if($method != 'ajax_list'){
            //   if($this->session->userdata('status')!='login'){
            //     redirect(base_url('login'));
            //   }
            // }
        }

        public function index()
        {$datatransaksi=$this->Transaksi_model->get_all();//panggil ke modell
          $datafield=$this->Transaksi_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'admin/transaksi/transaksi_list',
             'sidebar'=>'admin/sidebar',
             'css'=>'admin/transaksi/css',
             'js'=>'admin/transaksi/js',
             'datatransaksi'=>$datatransaksi,
             'datafield'=>$datafield,
             'module'=>'admin',
             'titlePage'=>'transaksi',
             'controller'=>'transaksi'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Transaksi_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Transaksi_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Transaksi_model->id_barang;
							$row[] = $Transaksi_model->id_pembeli;
							$row[] = $Transaksi_model->tanggal;
							$row[] = $Transaksi_model->keterangan;
							
              $row[] ="
              <a href='transaksi/edit/$Transaksi_model->id_transaksi'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Transaksi_model->id_transaksi' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Transaksi_model->count_all(),
                          "recordsFiltered" => $this->Transaksi_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $data = array(
             'content'=>'admin/transaksi/transaksi_create',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/transaksi/create_action',
             'module'=>'admin',
             'titlePage'=>'transaksi',
             'controller'=>'transaksi'
            );
          $this->template->load($data);
        }

        public function edit($id_transaksi){
          $dataedit=$this->Transaksi_model->get_by_id($id_transaksi);
           $data = array(
             'content'=>'admin/transaksi/transaksi_edit',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/transaksi/update_action',
             'dataedit'=>$dataedit,
             'module'=>'admin',
             'titlePage'=>'transaksi',
             'controller'=>'transaksi'
            );
          $this->template->load($data);
        }
public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
					'id_barang' => $this->input->post('id_barang',TRUE),
					'id_pembeli' => $this->input->post('id_pembeli',TRUE),
					'tanggal' => $this->input->post('tanggal',TRUE),
					'keterangan' => $this->input->post('keterangan',TRUE),
					
);

            $this->Transaksi_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/transaksi'));
        }
    }




    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id', TRUE));
        } else {
            $data = array(
					'id_barang' => $this->input->post('id_barang',TRUE),
					'id_pembeli' => $this->input->post('id_pembeli',TRUE),
					'tanggal' => $this->input->post('tanggal',TRUE),
					'keterangan' => $this->input->post('keterangan',TRUE),
					
);

            $this->Transaksi_model->update($this->input->post('id_transaksi', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/transaksi'));
        }
    }

    public function delete($id_transaksi)
    {
        $row = $this->Transaksi_model->get_by_id($id_transaksi);

        if ($row) {
            $this->Transaksi_model->delete($id_transaksi);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/transaksi'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/transaksi'));
        }
    }

    public function _rules()
    {
$this->form_validation->set_rules('id_barang', 'id_barang', 'trim|required');
$this->form_validation->set_rules('id_pembeli', 'id_pembeli', 'trim|required');
$this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');


	$this->form_validation->set_rules('id_transaksi', 'id_transaksi', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    }

}