<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class Pembayaran extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('Pembayaran_model');
            $this->load->library('form_validation');
	    $method=$this->router->fetch_method();
            // if($method != 'ajax_list'){
            //   if($this->session->userdata('status')!='login'){
            //     redirect(base_url('login'));
            //   }
            // }
        }

        public function index()
        {$datapembayaran=$this->Pembayaran_model->get_all();//panggil ke modell
          $datafield=$this->Pembayaran_model->get_field();//panggil ke modell

           $data = array(
             'content'=>'admin/pembayaran/pembayaran_list',
             'sidebar'=>'admin/sidebar',
             'css'=>'admin/pembayaran/css',
             'js'=>'admin/pembayaran/js',
             'datapembayaran'=>$datapembayaran,
             'datafield'=>$datafield,
             'module'=>'admin',
             'titlePage'=>'pembayaran',
             'controller'=>'pembayaran'
            );
          $this->template->load($data);
        }

        //DataTable
        public function ajax_list()
      {
          $list = $this->Pembayaran_model->get_datatables();
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $Pembayaran_model) {
              $no++;
              $row = array();
              $row[] = $no;
							$row[] = $Pembayaran_model->tgl_bayar;
							$row[] = $Pembayaran_model->total_bayar;
							$row[] = $Pembayaran_model->id_transaksi;
							
              $row[] ="
              <a href='pembayaran/edit/$Pembayaran_model->id_pembayaran'><i class='m-1 feather icon-edit-2'></i></a>
              <a class='modalDelete' data-toggle='modal' data-target='#responsive-modal' value='$Pembayaran_model->id_pembayaran' href='#'><i class='feather icon-trash'></i></a>";
              $data[] = $row;
          }

          $output = array(
                          "draw" => $_POST['draw'],
                          "recordsTotal" => $this->Pembayaran_model->count_all(),
                          "recordsFiltered" => $this->Pembayaran_model->count_filtered(),
                          "data" => $data,
                  );
          //output to json format
          echo json_encode($output);
      }


        public function create(){
           $data = array(
             'content'=>'admin/pembayaran/pembayaran_create',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/pembayaran/create_action',
             'module'=>'admin',
             'titlePage'=>'pembayaran',
             'controller'=>'pembayaran'
            );
          $this->template->load($data);
        }

        public function edit($id_pembayaran){
          $dataedit=$this->Pembayaran_model->get_by_id($id_pembayaran);
           $data = array(
             'content'=>'admin/pembayaran/pembayaran_edit',
             'sidebar'=>'admin/sidebar',
             'action'=>'admin/pembayaran/update_action',
             'dataedit'=>$dataedit,
             'module'=>'admin',
             'titlePage'=>'pembayaran',
             'controller'=>'pembayaran'
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
					'tgl_bayar' => $this->input->post('tgl_bayar',TRUE),
					'total_bayar' => $this->input->post('total_bayar',TRUE),
					'id_transaksi' => $this->input->post('id_transaksi',TRUE),
					
);

            $this->Pembayaran_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('admin/pembayaran'));
        }
    }




    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->edit($this->input->post('id', TRUE));
        } else {
            $data = array(
					'tgl_bayar' => $this->input->post('tgl_bayar',TRUE),
					'total_bayar' => $this->input->post('total_bayar',TRUE),
					'id_transaksi' => $this->input->post('id_transaksi',TRUE),
					
);

            $this->Pembayaran_model->update($this->input->post('id_pembayaran', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('admin/pembayaran'));
        }
    }

    public function delete($id_pembayaran)
    {
        $row = $this->Pembayaran_model->get_by_id($id_pembayaran);

        if ($row) {
            $this->Pembayaran_model->delete($id_pembayaran);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('admin/pembayaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/pembayaran'));
        }
    }

    public function _rules()
    {
$this->form_validation->set_rules('tgl_bayar', 'tgl_bayar', 'trim|required');
$this->form_validation->set_rules('total_bayar', 'total_bayar', 'trim|required');
$this->form_validation->set_rules('id_transaksi', 'id_transaksi', 'trim|required');


	$this->form_validation->set_rules('id_pembayaran', 'id_pembayaran', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    }

}