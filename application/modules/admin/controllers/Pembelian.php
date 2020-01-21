<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Pembelian extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Pembelian_model');
            $this->load->library('form_validation');
	    $method=$this->router->fetch_method();
            // if($method != 'ajax_list'){
            //   if($this->session->userdata('status')!='login'){
            //     redirect(base_url('login'));
            //   }
            // }
        }

        public function index()
        {$datapembelian=$this->Pembelian_model->get_all();//panggil ke modell
          $datafield=$this->Pembelian_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'admin/pembelian/pembeli_list',
             'sidebar'=>'admin/sidebar',
             'css'=>'admin/pembelian/css',
             'js'=>'admin/pembelian/js',
             'datapembelian'=>$datapembelian,
             'datafield'=>$datafield,
             'module'=>'admin',
             'titlePage'=>'pembelian',
             'controller'=>'pembelian'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Pembelian_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Pembelian_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Pembelian_model->nama_pembeli;
							$row[] = $Pembelian_model->jk;
							$row[] = $Pembelian_model->no_telp;
							$row[] = $Pembelian_model->alamat;
							
              $row[] ="
              <a href='pembelian/edit/$Pembelian_model->id_pembeli'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Pembelian_model->id_pembeli' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Pembelian_model->count_all(),
                          "recordsFiltered" => $this->Pembelian_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $data = array(
             'content'=>'admin/pembelian/pembeli_create',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/pembelian/create_action',
             'module'=>'admin',
             'titlePage'=>'pembelian',
             'controller'=>'pembelian'
            );
          $this->template->load($data);
        }

        public function edit($id_pembeli){
          $dataedit=$this->Pembelian_model->get_by_id($id_pembeli);
           $data = array(
             'content'=>'admin/pembelian/pembeli_edit',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/pembelian/update_action',
             'dataedit'=>$dataedit,
             'module'=>'admin',
             'titlePage'=>'pembelian',
             'controller'=>'pembelian'
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
					'nama_pembeli' => $this->input->post('nama_pembeli',TRUE),
					'jk' => $this->input->post('jk',TRUE),
					'no_telp' => $this->input->post('no_telp',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					
);

            $this->Pembelian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pembelian'));
        }
    }




    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id', TRUE));
        } else {
            $data = array(
					'nama_pembeli' => $this->input->post('nama_pembeli',TRUE),
					'jk' => $this->input->post('jk',TRUE),
					'no_telp' => $this->input->post('no_telp',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					
);

            $this->Pembelian_model->update($this->input->post('id_pembeli', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pembelian'));
        }
    }

    public function delete($id_pembeli)
    {
        $row = $this->Pembelian_model->get_by_id($id_pembeli);

        if ($row) {
            $this->Pembelian_model->delete($id_pembeli);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pembelian'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pembelian'));
        }
    }

    public function _rules()
    {
$this->form_validation->set_rules('nama_pembeli', 'nama_pembeli', 'trim|required');
$this->form_validation->set_rules('jk', 'jk', 'trim|required');
$this->form_validation->set_rules('no_telp', 'no_telp', 'trim|required');
$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');


	$this->form_validation->set_rules('id_pembeli', 'id_pembeli', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    }

}