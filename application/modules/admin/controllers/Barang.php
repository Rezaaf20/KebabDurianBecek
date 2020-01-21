<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Barang extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Barang_model');
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
        {$databarang=$this->Barang_model->get_all();//panggil ke modell
          $datafield=$this->Barang_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'admin/barang/barang_list',
             'sidebar'=>'admin/sidebar',
             'css'=>'admin/barang/css',
             'js'=>'admin/barang/js',
             'databarang'=>$databarang,
             'datafield'=>$datafield,
             'module'=>'admin',
             'titlePage'=>'barang',
             'controller'=>'barang'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Barang_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Barang_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Barang_model->nama_barang;
							$row[] = $Barang_model->harga;
							$row[] = $Barang_model->stok;
							$row[] = $Barang_model->id_supplier;

              $row[] ="
              <a href='barang/edit/$Barang_model->id_barang'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Barang_model->id_barang' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Barang_model->count_all(),
                          "recordsFiltered" => $this->Barang_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $supplier = $this->Supplier_model->get_all();
           $data = array(
             'content'=>'admin/barang/barang_create',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/barang/create_action',
             'module'=>'admin',
             'titlePage'=>'barang',
             'controller'=>'barang',
             'supplier'=>$supplier
            );
          $this->template->load($data);
        }

        public function edit($id_barang){
          $dataedit=$this->Barang_model->get_by_id($id_barang);
           $data = array(
             'content'=>'admin/barang/barang_edit',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/barang/update_action',
             'dataedit'=>$dataedit,
             'module'=>'admin',
             'titlePage'=>'barang',
             'controller'=>'barang'
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
					'nama_barang' => $this->input->post('nama_barang',TRUE),
					'harga' => $this->input->post('harga',TRUE),
					'stok' => $this->input->post('stok',TRUE),
					'id_supplier' => $this->input->post('id_supplier',TRUE),

);

            $this->Barang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/barang'));
        }
    }




    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id', TRUE));
        } else {
            $data = array(
    					'nama_barang' => $this->input->post('nama_barang',TRUE),
    					'harga' => $this->input->post('harga',TRUE),
    					'stok' => $this->input->post('stok',TRUE),
    					'id_supplier' => $this->input->post('id_supplier',TRUE),
            );

            $this->Barang_model->update($this->input->post('id_barang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/barang'));
        }
    }

    public function delete($id_barang)
    {
        $row = $this->Barang_model->get_by_id($id_barang);

        if ($row) {
            $this->Barang_model->delete($id_barang);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/barang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/barang'));
        }
    }

    public function _rules()
    {
$this->form_validation->set_rules('nama_barang', 'nama_barang', 'trim|required');
$this->form_validation->set_rules('harga', 'harga', 'trim|required');
$this->form_validation->set_rules('stok', 'stok', 'trim|required');
$this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim|required');


	$this->form_validation->set_rules('id_barang', 'id_barang', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    }

}
