<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Supplier extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Supplier_model');
            $this->load->library('form_validation');
	    $method=$this->router->fetch_method();
            // if($method != 'ajax_list'){
            //   if($this->session->userdata('status')!='login'){
            //     redirect(base_url('login'));
            //   }
            // }
        }

        public function index()
        {$datasupplier=$this->Supplier_model->get_all();//panggil ke modell
          $datafield=$this->Supplier_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'supplier/supplier/supplier_list',
             'sidebar'=>'supplier/sidebar',
             'css'=>'supplier/supplier/css',
             'js'=>'supplier/supplier/js',
             'datasupplier'=>$datasupplier,
             'datafield'=>$datafield,
             'module'=>'supplier',
             'titlePage'=>'supplier',
             'controller'=>'supplier'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Supplier_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Supplier_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Supplier_model->nama_supplier;
							$row[] = $Supplier_model->no_telp;
							$row[] = $Supplier_model->alamat;
							
              $row[] ="
              <a href='supplier/edit/$Supplier_model->id_supplier'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Supplier_model->id_supplier' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Supplier_model->count_all(),
                          "recordsFiltered" => $this->Supplier_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $data = array(
             'content'=>'supplier/supplier/supplier_create',
             'sidebar'=>'supplier/sidebar',
             'action'=>'supplier/supplier/create_action',
             'module'=>'supplier',
             'titlePage'=>'supplier',
             'controller'=>'supplier'
            );
          $this->template->load($data);
        }

        public function edit($id_supplier){
          $dataedit=$this->Supplier_model->get_by_id($id_supplier);
           $data = array(
             'content'=>'supplier/supplier/supplier_edit',
             'sidebar'=>'supplier/sidebar',
             'action'=>'supplier/supplier/update_action',
             'dataedit'=>$dataedit,
             'module'=>'supplier',
             'titlePage'=>'supplier',
             'controller'=>'supplier'
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
					'nama_supplier' => $this->input->post('nama_supplier',TRUE),
					'no_telp' => $this->input->post('no_telp',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					
);

            $this->Supplier_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('supplier/supplier'));
        }
    }




    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id', TRUE));
        } else {
            $data = array(
					'nama_supplier' => $this->input->post('nama_supplier',TRUE),
					'no_telp' => $this->input->post('no_telp',TRUE),
					'alamat' => $this->input->post('alamat',TRUE),
					
);

            $this->Supplier_model->update($this->input->post('id_supplier', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('supplier/supplier'));
        }
    }

    public function delete($id_supplier)
    {
        $row = $this->Supplier_model->get_by_id($id_supplier);

        if ($row) {
            $this->Supplier_model->delete($id_supplier);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('supplier/supplier'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('supplier/supplier'));
        }
    }

    public function _rules()
    {
$this->form_validation->set_rules('nama_supplier', 'nama_supplier', 'trim|required');
$this->form_validation->set_rules('no_telp', 'no_telp', 'trim|required');
$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');


	$this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    }

}