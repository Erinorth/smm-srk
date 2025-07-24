<?php

namespace App\View\Components\DataTable;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class DeleteScript extends Component
{
    public $url;
    public $deleteName;
    
    /**
     * สร้าง component instance ใหม่
     *
     * @return void
     */
    public function __construct($url, $deleteName)
    {
        $this->url = $url;
        $this->deleteName = $deleteName;
        
        // เพิ่ม log เพื่อตรวจสอบการใช้งาน component
        Log::info('DeleteScript Component created', [
            'url' => $url,
            'deleteName' => $deleteName
        ]);
    }

    /**
     * รับ view / contents ที่แสดง component
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return <<<'blade'
var user_id;

$(document).on('click', '.delete{{$deleteName}}', function(){
    user_id = $(this).attr('id');
    $('.modal-title{{$deleteName}}').text('Confirmation');
    $('#ok_button{{$deleteName}}').text('Delete');
    $('#confirmModal{{$deleteName}}').modal('show');
    
    // เพิ่ม log สำหรับตรวจสอบการคลิก delete
    console.log('Delete button clicked for ID: ' + user_id);
});

$('#ok_button{{$deleteName}}').click(function(){
    // สร้าง URL โดยใช้ Laravel URL helper แทนการใช้ string ธรรมดา
    var deleteUrl = "{{ url($url . '/destroy') }}/" + user_id;
    
    console.log('Sending delete request to: ' + deleteUrl);
    
    $.ajax({
        url: deleteUrl, // ใช้ Laravel URL helper
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // เพิ่ม CSRF token
        },
        beforeSend: function(){
            $('#ok_button{{$deleteName}}').text('Deleting...');
            $('#ok_button{{$deleteName}}').prop('disabled', true); // ปิดการใช้งานปุ่มระหว่างลบ
        },
        success: function(data) {
            console.log('Delete successful:', data);
            setTimeout(function(){
                $('#confirmModal{{$deleteName}}').modal('hide');
                alert('Data Deleted Successfully');
                location.reload();
            }, 1000); // ลดเวลารอให้เร็วขึ้น
        },
        error: function(xhr, status, error) {
            // เพิ่ม error handling
            console.error('Delete failed:', error);
            alert('Error deleting data: ' + error);
            $('#ok_button{{$deleteName}}').text('Delete');
            $('#ok_button{{$deleteName}}').prop('disabled', false);
        },
        complete: function() {
            // รีเซ็ตปุ่มเมื่อ request เสร็จสิ้น
            $('#ok_button{{$deleteName}}').text('Delete');
            $('#ok_button{{$deleteName}}').prop('disabled', false);
        }
    });
});
blade;
    }
}
