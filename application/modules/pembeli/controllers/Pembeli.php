<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Pembeli extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Pembeli_model');
            $this->load->library('form_validation');
	    $method=$this->router->fetch_method();
            // if($method != 'ajax_list'){
            //   if($this->session->userdata('status')!='login'){
            //     redirect(base_url('login'));
            //   }
            // }
        }

        public function index()
        {$datapembeli=$this->Pembeli_model->get_all();//panggil ke modell
          $datafield=$this->Pembeli_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'pembeli/pembeli/pembeli_list',
             'sidebar'=>'pembeli/sidebar',
             'css'=>'pembeli/pembeli/css',
             'js'=>'pembeli/pembeli/js',
             'datapembeli'=>$datapembeli,
             'datafield'=>$datafield,
             'module'=>'pembeli',
             'titlePage'=>'pembeli',
             'controller'=>'pembeli'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Pembeli_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Pembeli_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Pembeli_model->nama_pembeli;
							$row[] = $Pembeli_model->jk;
							$row[] = $Pembeli_model->no_telp;
							$row[] = $Pembeli_model->alamat;
							
              $row[] ="
              <a href='pembeli/edit/$Pembeli_model->id_pembeli'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Pembeli_model->id_pembeli' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Pembeli_model->count_all(),
                          "recordsFiltered" => $this->Pembeli_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $data = array(
             'content'=>'pembeli/pembeli/pembeli_create',
             'sidebar'=>'pembeli/sidebar',
             'action'=>'pembeli/pembeli/create_action',
             'module'=>'pembeli',
             'titlePage'=>'pembeli',
             'controller'=>'pembeli'
            );
          $this->template->load($data);
        }

        public function edit($id_pembeli){
          $dataedit=$this->Pembeli_model->get_by_id($id_pembeli);
           $data = array(
             'content'=>'pembeli/pembeli/pembeli_edit',
             'sidebar'=>'pembeli/sidebar',
             'action'=>'pembeli/pembeli/update_action',
             'dataedit'=>$dataedit,
             'module'=>'pembeli',
             'titlePage'=>'pembeli',
             'controller'=>'pembeli'
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

            $this->Pembeli_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('pembeli/pembeli'));
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

            $this->Pembeli_model->update($this->input->post('id_pembeli', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pembeli/pembeli'));
        }
    }

    public function delete($id_pembeli)
    {
        $row = $this->Pembeli_model->get_by_id($id_pembeli);

        if ($row) {
            $this->Pembeli_model->delete($id_pembeli);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pembeli/pembeli'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pembeli/pembeli'));
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