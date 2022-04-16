<?php
class Salary extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('news_model');
        $this->load->model('news_type_model');
        $this->load->model('news_salary_model');
        $this->load->model('category_model');
        $this->load->model('view_money_model');
        $this->load->model('log_view_model');
        $this->data['breadcrumbs'] = array('Salary' => base_url('salary'));
    }

    public function newsTypeConfig($id=null)
    {
    	$rules = $this->news_type_model->rules;
    	$this->form_validation->set_rules($rules);

    	if ($this->form_validation->run() == TRUE) {
    		$inputParams = array('name', 'description', 'min', 'max', 'fixed_money');
    		$data = $this->news_type_model->array_from_post($inputParams);
            $data['slugname'] = build_slug($data['name']);
    		$data['fixed_money'] = intval($data['fixed_money']);
            $mins = $data['min'];
            $maxs = $data['max'];
            unset($data['min']);
            unset($data['max']);
            $moneyStep = array();

            foreach ($mins as $key => $minVal) {
                $moneyStep[] = $minVal . ':' . $maxs[$key];
            }
            $data['view_money'] = implode(',', $moneyStep);

    		//check slugname existed
    		if ( ! $id && $this->news_type_model->get_by( array('slugname' => $data['slugname']) )) {
    			$this->session->set_flashdata('session_error', 'Loại cấu hình đã tồn tại');
    		}
    		else
    		{
    			if ( ! $savedId = $this->news_type_model->save($data, $id)) 
    				$this->session->set_flashdata('session_error', 'Lỗi! Không thể cập nhật dữ liệu.');
        		else
        			$this->session->set_flashdata('session_msg', 'Lưu dữ liệu thành công.');
    		}
    	}

    	$this->data['allType'] = $this->news_type_model->get();
        $this->data['newsType'] = $this->news_type_model->getDetailType($id);

    	//breadcrumbs
    	$this->data['breadcrumbs']['phân loại'] = base_url('salary/newsTypeConfig');

    	//loadView
        $this->data['sub_view'] = 'admin/salary/config-news-type';
        $this->data['sub_js'] = $this->data['sub_view']  . '-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function deleteNewsType($id='')
    {
    	if ( $this->news_type_model->delete($id))
    		$this->session->set_flashdata('session_msg', 'Xóa dữ liệu thành công');
    	else
    		$this->session->set_flashdata('session_error', 'Lỗi! Không thể cập nhật dữ liệu');
    	redirect( base_url('salary/newsTypeConfig') ,'refresh');
    }

    public function configViewQuota($value='')
    {

    	//loadView
        $this->data['sub_view'] = 'admin/salary/config-view-quota';
        $this->data['sub_js'] = $this->data['sub_view']  . '-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function salaryMonth()
    {
        //fetch all active author
        $this->data['authors'] = $listAuthor = $this->user_model->get_by( array('status' => STATUS_PUBLISHED) );
        
        $filter = array();
        $month = ($this->input->get_post('month')) ? intval($this->input->get_post('month')) : date('m', time());
        $year = ($this->input->get_post('year')) ? intval($this->input->get_post('year')) : date('Y', time());
        $create_by = ($this->input->get_post('create_by')) ? intval($this->input->get_post('create_by')) : NULL;
        $page = ($this->input->get_post('page')) ? intval($this->input->get_post('page')) : 1;
        $minView = ($this->input->get_post('min_view')) ? intval($this->input->get_post('min_view')) : NULL;
        $maxView = ($this->input->get_post('max_view')) ? intval($this->input->get_post('max_view')) : NULL;
        $is_writer = ($this->input->get_post('is_writer')) ? trim($this->input->get_post('is_writer')) : NULL;
        
        $this->data['inputParams'] = array();
        $this->data['inputParams']['month'] = intval($this->input->get_post('month'));
        $this->data['inputParams']['year'] = intval($this->input->get_post('year'));

        if ($year >= date('Y', time())) {
            $year = date('Y', time());
            $_thisMonth = date('m');
            if ($month >= $_thisMonth) {
                $month = $_thisMonth;
                $today = date('d', time());
                if ($today < END_DAY_OF_MONTH + DAY_OF_COUNTER) {
                    $month = date('m', strtotime('first day of last month'));
                    $this->data['error_msg'] = sprintf( $this->lang->line('salary_not_up_to_date'), $this->data['inputParams']['month'], $this->data['inputParams']['year'], END_DAY_OF_MONTH + DAY_OF_COUNTER +1, $this->data['inputParams']['month'] );
                }
            }
        }

        if ( ! $create_by) {
            $createAuthor = $listAuthor[0];
            $create_by = $createAuthor->id;
        }

        //config listTitle
        $listTitle = 'Danh sách bài viết';
        if ($minView) 
            $listTitle = 'Danh sách bài viết đủ điều kiện tính nhuận bút';
        if ($maxView) 
            $listTitle = 'Danh sách bài viết không được tính nhuận bút';
        if ($is_writer == 'true') 
            $listTitle = 'Danh sách bài tự viết';
        if ($is_writer == 'false') 
            $listTitle = 'Danh sách bài tổng hợp';
        $this->data['listTitle'] = $listTitle;

        //$this->data['categories'] = $this->category_model->get();
        $this->data['newsTypes'] = $this->news_type_model->getAllType( array('has_view_money' => 'true') );
        $this->data['author'] = $this->user_model->get($create_by, TRUE);

        $this->data['filterConds'] = array();
        $this->data['filterConds']['create_by'] = $create_by;
        $this->data['filterConds']['month'] = $month;
        $this->data['filterConds']['year'] = $year;
        $this->data['filterConds']['page'] = $page;
        $this->data['filterConds']['is_writer'] = $is_writer;

        $params = array();
        $paging = $this->data['paging'] = build_pagination($page, LIMIT);

        $params['author_id'] = $create_by;
        $params['offset'] = $paging['offset'];
        $params['limit'] = $paging['limit'];
        $params['join_type'] = 'left';
        $params['is_writer'] = $is_writer;
        if ($minView) $params['min_view'] = $minView;
        if ($maxView) $params['max_view'] = $maxView;
        if ($month) 
        {
            //fetch previous month
            $lastMonth = $month-1%12;
            $prevYear = ($lastMonth == 0) ? ($year-1) : $year;
            $prevMonth = ($lastMonth==0) ? '12' : $lastMonth;
            $prevDay = END_DAY_OF_MONTH+1;
            $params['start_date'] = "{$prevYear}-{$prevMonth}-{$prevDay}";
            $params['end_date'] = "{$year}-{$month}-" . END_DAY_OF_MONTH;
        }
        $this->data['params'] = $params;
        $this->data['listNews'] = $this->news_salary_model->getListNews2SalaryByAuthor($params);

        //Fetch report this author
        $args = array();
        $args['create_by'] = $create_by;
        $args['start_time'] = strtotime($params['start_date'] . ' 00:00:00');
        $args['end_time'] = strtotime($params['end_date'] . ' 23:59:59');
        $this->data['reportMonth'] = $this->news_model->countNewsNumber($args);

        //load view
        $this->data['sub_view'] = 'admin/salary/salary-cal';
        $this->data['sub_js'] = $this->data['sub_view']  . '-js';
        $this->load->view('admin/_layout_main',$this->data);
    }

    public function newsNote($newsId)
    {
        $data = array();
        $data['news'] = $this->news_model->get($newsId, TRUE);
        $data['newsSalary'] = $this->news_salary_model->getDetail($newsId);

        //load view
        $this->load->view('admin/modal/note-news-for-salary', $data);
    }

    public function export() {
        $authorId = ($this->input->get_post('create_by')) ? intval($this->input->get_post('create_by')) : NULL;
        $month = ($this->input->get_post('month')) ? intval($this->input->get_post('month')) : NULL;
        $year = ($this->input->get_post('year')) ? intval($this->input->get_post('year')) : NULL;

        $author = $this->user_model->get($authorId, TRUE);
        $params['author_id'] = $authorId;
        $params['offset'] = 0;
        $params['limit'] = LIMIT * 50;
        $params['join_type'] = 'left';
        if ($month) 
        {
            $params['start_date'] = "{$year}-{$month}-1";
            $params['end_date'] = date('Y-m-t', strtotime("{$year}-{$month}-1"));
        }
        $listNews = $this->news_salary_model->getListNews2SalaryByAuthor($params);
        $categories = $this->category_model->get();
        foreach ($categories as $key => $value) {
            $listCategory[$value->id] = $value;
        }
        $queryType = $this->news_type_model->getAllType();
        foreach ($queryType as $key => $value) {
            $salaryType[$value->id] = $value;
        }

        $this->load->library('PHPExcel');
        //$this->load->library('PHPExcel/pHPExcel_IOFactory');

        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("THCL - Online System")
        ->setLastModifiedBy("THCL")
        ->setTitle("Báo cáo nhuận bút tháng {$month}/{$year}")
        ->setSubject("Báo cáo nhuận bút tháng {$month}/{$year}")
        ->setDescription("Báo cáo nhuận bút tháng {$month}/{$year}")
        ->setKeywords("Báo cáo nhuận bút tháng {$month}/{$year}")
        ->setCategory("Báo cáo nhuận bút tháng {$month}/{$year}");
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'STT')
        ->setCellValue('B1', 'Tiêu đề!')
        ->setCellValue('C1', 'Chuyên mục')
        ->setCellValue('D1', 'Nguồn')
        ->setCellValue('E1', 'View')
        ->setCellValue('F1', 'Phân loại')
        ->setCellValue('G1', 'Thu nhập')
        ->setCellValue('H1', 'Ghi chú')
        ->setCellValue('I1', 'Link');
        $sumView = $sumMoney = 0;

        foreach ($listNews as $key => $val) {
            $_cat = (isset($listCategory[$val->category])) ? $listCategory[$val->category] : NULL;
            $_type = (isset($val->type_id) && isset($salaryType[$val->type_id])) ? $salaryType[$val->type_id] : NULL;
            $_source = ($val->source_url) ? 'Tổng hợp' : 'Tự viết';
            $sumView += $val->hit_view;
            $sumMoney += $val->money;
            $row = $key + 2;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, $key+1)
            ->setCellValue('B' . $row, $val->title)
            ->setCellValue('C' . $row, ($_cat) ? $_cat->title : 'Not set')
            ->setCellValue('D' . $row, $_source)
            ->setCellValue('E' . $row, $val->hit_view)
            ->setCellValue('F' . $row, ($_type) ? $_type->name : 'Not set')
            ->setCellValue('G' . $row, number_format($val->money))
            ->setCellValue('H' . $row, $val->note)
            ->setCellValue('I' . $row, link_preview_detail_news($val->slugname, $val->id));
        }
        $lastRow = count($listNews) + 2;
        $objPHPExcel->getActiveSheet()->mergeCells("A{$lastRow}:D{$lastRow}");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $lastRow, 'Tổng')
            ->setCellValue('E' . $lastRow, number_format($sumView))
            ->setCellValue('F' . $lastRow, '')
            ->setCellValue('G' . $lastRow, number_format($sumMoney))
            ->setCellValue('H' . $lastRow, '');
        // Miscellaneous glyphs, UTF-8
                
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($author->name);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="THCL-'.$month.'-'.$year.'-'.build_slug($author->name).'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

    public function reportSalaryByMonth()
    {
        $action = ($this->input->get_post('action')) ? $this->input->get_post('action') : NULL;
        if ($action && $action != 'export')
            $action = NULL;

        $today = date('d', time());
        $currentMonth = date('m');
        $currentYear = date('Y');

        $month = (intval($this->input->get_post('m'))) ? intval($this->input->get_post('m')) : $currentMonth;
        $year = (intval($this->input->get_post('y'))) ? intval($this->input->get_post('y')) : $currentYear;
        if ($year > $currentYear || ($year == $currentYear && $month > $currentMonth) ) {
            $month = $currentMonth;
            $year = $currentYear;
        }
        
        //Neu chua den ngay cham cong, tu dong lay thang truoc
        if ($today < (END_DAY_OF_MONTH + DAY_OF_COUNTER) && $month==$currentMonth && $year==$currentYear ) {
            $_lastMonth = strtotime('first day of last month');
            $month = date('m', $_lastMonth);
            $year = date('Y', $_lastMonth);
        }

        $lastMonth = $month-1%12;
        $startYear = ($lastMonth == 0) ? ($year-1) : $year;
        $startMonth = ($lastMonth==0) ? '12' : $lastMonth;
        $startDay = END_DAY_OF_MONTH + 1;
        $startDate = "{$startYear}-{$startMonth}-{$startDay}";
        $endDate = "{$year}-{$month}-". END_DAY_OF_MONTH;

        $this->data['filterParams'] = array();
        $this->data['filterParams']['month'] = $month;
        $this->data['filterParams']['year'] = $year;

        $args = array(
            'from_time' => strtotime($startDate . ' 00:00:00'),
            'to_time' => strtotime($endDate . ' 23:59:59')
        );
        $authorIdInMonth = $this->news_model->getAuthorHasArticle($args);
        if (! $authorIdInMonth) $authorIdInMonth = array();
        $authorIdConfirmedSalary = $this->news_salary_model->getAuthorHasConfirmSalaryArticle($args);
        if (! $authorIdConfirmedSalary) $authorIdConfirmedSalary = array();
        $_authorsNotConfirm = array_diff($authorIdInMonth, $authorIdConfirmedSalary);
        
        // if ( $this->data['userdata']['id'] == 9 ) {
        //     print_r('<pre>');
        //     print_r($authorIdInMonth);
        //     print_r($authorIdConfirmedSalary);
        //     print_r('<pre>');
        //     exit();
        // }
        
        //PV co bai viet nhung chua dang ky nhuan but
        $_listAuthorNotRegSalary = $this->news_model->getListAuthorNotRegSalary($args);
        
        if (! $_listAuthorNotRegSalary)
            $_listAuthorNotRegSalary = array();
        
        $authorsNotConfirm = array_unique( array_merge($_authorsNotConfirm, $_listAuthorNotRegSalary) );

        //test
        $this->data['reportSalary'] = $this->news_salary_model->getReportByAuthor($args);

        if ($authorsNotConfirm) 
            $this->data['authorConfirmNotYet'] = $this->user_model->getUserById( $authorsNotConfirm );
        else
            $this->data['reportSalary'] = $this->news_salary_model->getReportByAuthor($args);

        if ($action == 'export' && isset($this->data['reportSalary'])) 
        {
            # Export to file
            $exportData = array(
                'month' => $month,
                'year' => $year,
                'data' => $this->data['reportSalary']
            );
            $this->__exportMonthlyReportSalary($exportData);
        }
        else
        {
            //Load view
            $this->data['sub_view'] = 'admin/salary/salary-report';
            $this->data['sub_js'] = $this->data['sub_view']  . '-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
    }

    private function __exportMonthlyReportSalary($args)
    {
        $month = $args['month'];
        $year = $args['year'];
        $data = $args['data'];
        $this->load->library('PHPExcel');
        //$this->load->library('PHPExcel/pHPExcel_IOFactory');

        $border_style= array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
            )
        );
        $txtBoldCenter = array(
            'font' => array('size' => 16,'bold' => true,'color' => array('rgb' => '000000')),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $txtRight = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );
        $txtCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );


        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("THCL - Online System")
        ->setLastModifiedBy("THCL")
        ->setTitle("Tổng kết nhuận bút tháng {$month}/{$year}")
        ->setSubject("Tổng kết nhuận bút tháng {$month}/{$year}")
        ->setDescription("Tổng kết nhuận bút tháng {$month}/{$year}")
        ->setKeywords("Tổng kết nhuận bút tháng {$month}/{$year}")
        ->setCategory("Tổng kết nhuận bút tháng {$month}/{$year}");
        
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'BÁO THƯƠNG HIỆU VÀ CÔNG LUẬN')
        ->setCellValue('A2', '12 TT Bộ Tư pháp, ngõ 118 Nguyễn Khánh Toàn, Cầu Giấy, Hà Nội')
        ->setCellValue('A3', 'TỔNG KẾT NHUẬN BÚT ĐIỆN TỬ THÁNG ' . $month . '/' . $year);
        $objPHPExcel->getActiveSheet()->mergeCells("A1:F1");
        $objPHPExcel->getActiveSheet()->mergeCells("A2:F2");
        $objPHPExcel->getActiveSheet()->mergeCells("A3:F3");

        $objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($txtBoldCenter);
        
        $startRowIndex = 4;
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$startRowIndex, 'STT')
        ->setCellValue('B'.$startRowIndex, 'Họ và tên')
        ->setCellValue('C'.$startRowIndex, 'Số bài viết')
        ->setCellValue('D'.$startRowIndex, 'Nhuận bút')
        ->setCellValue('E'.$startRowIndex, 'Ngày tạo')
        ->setCellValue('F'.$startRowIndex, 'Ký tên');

        unset($txtBoldCenter['font']['size']);
        $objPHPExcel->getActiveSheet()->getStyle("A".$startRowIndex)->applyFromArray( array_merge($border_style, $txtCenter) );
        $objPHPExcel->getActiveSheet()->getStyle("B".$startRowIndex)->applyFromArray(array_merge($border_style, $txtBoldCenter));
        $objPHPExcel->getActiveSheet()->getStyle("C".$startRowIndex)->applyFromArray(array_merge($border_style, $txtBoldCenter));
        $objPHPExcel->getActiveSheet()->getStyle("D".$startRowIndex)->applyFromArray(array_merge($border_style, $txtBoldCenter));
        $objPHPExcel->getActiveSheet()->getStyle("E".$startRowIndex)->applyFromArray(array_merge($border_style, $txtBoldCenter));
        $objPHPExcel->getActiveSheet()->getStyle("F".$startRowIndex)->applyFromArray(array_merge($border_style, $txtBoldCenter));

        $sumMoney = 0;
        $sumNews = 0;
        foreach ($data as $key => $val) {
            $row = ++$startRowIndex;
            $sumNews += $val->news_number;
            $sumMoney += $val->sum_money;
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $row, $key+1)
            ->setCellValue('B' . $row, $val->name)
            ->setCellValue('C' . $row, number_format($val->news_number))
            ->setCellValue('D' . $row, number_format($val->sum_money))
            ->setCellValue('E' . $row, date('d/m/Y', time()))
            ->setCellValue('F' . $row, '');

            $objPHPExcel->getActiveSheet()->getStyle("A".$row)->applyFromArray(array_merge($border_style, $txtBoldCenter));
            $objPHPExcel->getActiveSheet()->getStyle("B".$row)->applyFromArray($border_style);
            $objPHPExcel->getActiveSheet()->getStyle("C".$row)->applyFromArray($border_style);
            $objPHPExcel->getActiveSheet()->getStyle("D".$row)->applyFromArray(array_merge($border_style, $txtRight));
            $objPHPExcel->getActiveSheet()->getStyle("E".$row)->applyFromArray(array_merge($border_style, $txtRight));
            $objPHPExcel->getActiveSheet()->getStyle("F".$row)->applyFromArray($border_style);

        }
        $lastRow = $startRowIndex + 2;
        $objPHPExcel->getActiveSheet()->mergeCells("A{$lastRow}:F{$lastRow}");
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $lastRow, 'Hà Nội, ngày ' . date('d') . ' tháng ' . date(m) . ' năm ' . date(Y));

        $objPHPExcel->getActiveSheet()->getStyle("A".$lastRow)->applyFromArray($txtRight);
        
        $metaRow = $lastRow+1;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $metaRow, 'Người lập')
            ->setCellValue('C' . $metaRow, 'Kế toán')
            ->setCellValue('E' . $metaRow, 'Tổng biên tập');
        $objPHPExcel->getActiveSheet()->mergeCells("A{$metaRow}:B{$metaRow}");
        $objPHPExcel->getActiveSheet()->mergeCells("C{$metaRow}:D{$metaRow}");
        $objPHPExcel->getActiveSheet()->mergeCells("E{$metaRow}:F{$metaRow}");
        $objPHPExcel->getActiveSheet()->getStyle("A".$metaRow)->applyFromArray( $txtBoldCenter );
        $objPHPExcel->getActiveSheet()->getStyle("C".$metaRow)->applyFromArray( $txtBoldCenter );
        $objPHPExcel->getActiveSheet()->getStyle("E".$metaRow)->applyFromArray( $txtBoldCenter );

        $metaRow = $metaRow+4;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $metaRow, 'VŨ VĂN CHÍNH')
            ->setCellValue('C' . $metaRow, 'NGUYỄN VĂN TIẾP')
            ->setCellValue('E' . $metaRow, 'VŨ ĐỨC THUẬN');
        $objPHPExcel->getActiveSheet()->mergeCells("A{$metaRow}:B{$metaRow}");
        $objPHPExcel->getActiveSheet()->mergeCells("C{$metaRow}:D{$metaRow}");
        $objPHPExcel->getActiveSheet()->mergeCells("E{$metaRow}:F{$metaRow}");
        $objPHPExcel->getActiveSheet()->getStyle("A".$metaRow)->applyFromArray( $txtBoldCenter );
        $objPHPExcel->getActiveSheet()->getStyle("C".$metaRow)->applyFromArray( $txtBoldCenter );
        $objPHPExcel->getActiveSheet()->getStyle("E".$metaRow)->applyFromArray( $txtBoldCenter );

        // Miscellaneous glyphs, UTF-8
        // 
        // Style cells
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("10");
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('THCL_SYSTEM');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="thcl-salary-'.$month.'-'.$year.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        $objWriter->save('php://output');
        exit;
    }

}