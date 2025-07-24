@extends('adminlte::page')

@section('title', '
    Quality - Safety & Health Manual
')

@section('css')

@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Job</h1>
@stop

@section('content')
    <div class="container-sm">
        <h3>Safety & Health</h3>
        <h4>ความรุนแรง(Severity)</h4>
        <p style="text-indent: 2.5em;">ให้ระบุว่าระดับของความรุนแรงที่เกิดอันตรายอยู่ในระดับใดลงในแบบฟอร์มการประเมินความเสี่ยง(FM -001/QP-PB -029)ตามที่กาหนดไว้เป็น 3 ระดับ ลงในแบบฟอร์ม การประเมินความเสี่ยง(FM –001/QP-PB -029)</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th colspan="2" class="text-center align-middle">รุนแรงมาก</th>
                        <th colspan="2" class="text-center align-middle">รุนแรงปานกลาง</th>
                        <th colspan="2" class="text-center align-middle">รุนแรงน้อย</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">ทรัพย์สิน</th>
                        <th class="text-center align-middle">คน</th>
                        <th class="text-center align-middle">ทรัพย์สิน</th>
                        <th class="text-center align-middle">คน</th>
                        <th class="text-center align-middle">ทรัพย์สิน</th>
                        <th class="text-center align-middle">คน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>เสียหายมูลค่าเกิน 250,000 บาท</td>
                        <td>การบาดเจ็บ หรือเจ็บป่วย ต้องรับการรักษาที่โรงพยาบาล และแพทย์อนุญาตให้หยุดงานตั้งแต่ 3 วันขึ้นไป และหรือเป็นเหตุการณ์ที่ต้องประกาศใช้แผนฉุกเฉินและหรือเป็นเหตุการณ์ที่ทำให้ต้องสูญเสียอวัยวะ ทุพพลภาพเสียชีวิตพบผู้ป่วยจากการทำงาน</td>
                        <td>เสียหายมูลค่าตั้งแต่ 25,000 บาทแต่ไม่เกิน 250,000 บาท</td>
                        <td>การบาดเจ็บ หรือเจ็บป่วย ต้องรับการรักษาที่โรงพยาบาล และแพทย์อนุญาตให้หยุดงานไม่เกิน 3 วัน</td>
                        <td>เสียหายมูลค่าไม่เกิน 25,000 บาท</td>
                        <td>บาดเจ็บ หรือเจ็บป่วยเพียงเล็กน้อย การปฐมพยาบาลขั้นต้นไม่ต้องหยุดงาน</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h4>โอกาสที่เกิดอันตราย (Likelihood)</h4>
        <p style="text-indent: 2.5em;">โอกาสที่เกิดอันตรายให้พิจารณาตามตาราง ลงในแบบฟอร์ม การประเมินความเสี่ยง( FM -001/QP-PB -029)</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">หัวข้อในการพิจารณา</th>
                        <th colspan="3" class="text-center align-middle">คะแนน</th>
                        <th rowspan="2" class="text-center align-middle">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">1</th>
                        <th class="text-center align-middle">2</th>
                        <th class="text-center align-middle">3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. จำนวนคนที่ปฏิบัติ</td>
                        <td>จำนวนคนตามแผน</td>
                        <td>จำนวนคนไม่เหมาะสม</td>
                        <td>ไม่มีการวางแผนกำลังคน</td>
                        <td>ให้พิจารณาตามลักษณะของการเกิดอันตรายว่าถ้ามีผู้ปฏิบัติงานไม่เป็นไปตามแผน/ไม่เหมาะสมแล้วอาจจะทำให้มีโอกาสเกิดอันตราย</td>
                    </tr>
                    <tr>
                        <td>2. การสัมผัสแหล่งอันตราย</td>
                        <td>ไม่เป็นอันตราย</td>
                        <td>ไม่เป็นอันตรายทันทีหรือแค่แสบ, ระคายเคือง</td>
                        <td>เป็นอันตรายทันที</td>
                        <td>ให้พิจารณาเฉพาะงานที่ต้องสัมผัสสารเคมีความร้อน แสงจ้า เสียงดัง ฝุ่น กัมมันตรังสี</td>
                    </tr>
                    <tr>
                        <td>3. ขั้นตอนการปฏิบัติงาน</td>
                        <td>มีอย่างเหมาะสม</td>
                        <td>มีแต่ไม่เหมาะสม, ไม่เพียงพอ, ไม่ชัดเจน</td>
                        <td>ไม่มี</td>
                        <td>ขั้นตอนการปฎิบัติต้องเป็นเอกสาร</td>
                    </tr>
                    <tr>
                        <td>4. การอบรม</td>
                        <td>มีการอบรมและกำหนดเป็นความจำเป็นในการฝึกอบรม</td>
                        <td>มีการอบรมแต่ไม่มีการกำหนดความจำเป็นในการฝึกอบรม</td>
                        <td>ไม่มีการอบรม</td>
                        <td>ต้องมีประวัติการอบรม <br> ต้องมีการกำหนดแผนความต้องการฝึกอบรม</td>
                    </tr>
                    <tr>
                        <td>5. อุปกรณ์ป้องกันภัยส่วนบุคคล(PPE.)</td>
                        <td>มีอย่างเหมาะสม</td>
                        <td>มีแต่ไม่เหมาะสม</td>
                        <td>ไม่มี</td>
                        <td>มี Spec.ของ PPEที่เป็นมาตรฐาน</td>
                    </tr>
                    <tr>
                        <td>6. อุปกรณ์/เครื่องมือความปลอดภัย</td>
                        <td>มีและใช้งานได้ดี</td>
                        <td>มีแต่ใช้งานไม่ดี, ไม่เหมาะสม</td>
                        <td>ไม่มี</td>
                        <td>เช่น Safety Switch, Safety Cut out, Safety Limit หรือ Auto Stop ต่างๆเป็นต้น</td>
                    </tr>
                    <tr>
                        <td>7. ผลการตรวจการทำงาน/ความปลอดภัย</td>
                        <td>ปฏิบัติอย่างครบถ้วนทุกงาน</td>
                        <td>ปฏิบัติตามมาตรการมากกว่าหรือเท่ากับ 90%</td>
                        <td>ปฏิบัติตามมาตรการน้อยกว่า 90%</td>
                        <td>เช่น ความพร้อมผู้ปฏิบัติงาน ผู้รับเหมา การตรวจสอบพื้นที่/สภาพแวดล้อมก่อนเริ่มงานความพร้อม PPE เครื่องมือ อุปกรณ์ Pre-use การตรวจจาก จป.การสังเกตุการทำงาน ฯลฯ</td>
                    </tr>
                    <tr>
                        <td>8. การเตือนอันตราย</td>
                        <td>มีอย่างเหมาะสม</td>
                        <td>มีแต่ไม่เหมาะสม</td>
                        <td>ไม่มี</td>
                        <td>เช่น Safety Sign ตามมาตรฐาน, ป้ายเตือน, สัญญาณเตือนภัย,เสียงตามสาย ฯลฯ</td>
                    </tr>
                </tbody>
            </table>
            <p style="text-indent: 2.5em;">ให้พิจารณาโอกาสเกิดอันตรายในแต่ละหัวข้อที่เกี่ยวข้องกับงานที่ประเมินและให้คะแนนลงในแบบฟอร์ม(FM-001/QP-PB -029) ตามหัวข้อในตาราง ซึ่งจะมีการกำหนดคะแนนในแต่ละข้อไว้เช่นมีอย่างเหมาะสม= 1,มีแต่ไม่เหมาะสม= 2, ไม่มี= 3</p>
            <p style="text-indent: 2.5em;">ให้รวมคะแนนของโอกาสเกิดอันตรายทั้งหมด(จากข้อ 1-8) แล้วคูณด้วย 100 และหาร ด้วยผลรวมของคะแนนสูงสุดที่คิดได้โดยคำนวณเป็นเปอร์เซ็นต์เพื่อระบุเป็นค่าโอกาสเกิดอันตรายตามเกณฑ์ที่กาหนดไว้ ตามแบบฟอร์ม การประเมินความเสี่ยง(FM -001/QP-PB -029)</p>
            <p style="text-indent: 2.5em;">ในกรณีที่หัวข้อในการพิจารณาข้อไหนไม่เกี่ยวข้องกับงานที่ประเมินไม่ต้องนาคะแนนมาคิดเป็นคะแนนรวมทั้งหมด</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">ระดับโอกาสเกิดอันตราย</th>
                            <th class="text-center align-middle">คะแนน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">โอกาสเกิดอันตรายน้อย</td>
                            <td class="text-center">33.33-45.83%</td>
                        </tr>
                        <tr>
                            <td class="text-center">โอกาสเกิดอันตรายปานกลาง</td>
                            <td class="text-center">มากกว่า45.83-66.67%</td>
                        </tr>
                        <tr>
                            <td class="text-center">โอกาสเกิดอันตรายมาก</td>
                            <td class="text-center">มากกว่า 66.67 %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <h4>การสรุปความเสี่ยง/การตัดสินความเสี่ยง(Determine Risk)</h4>
        <p style="text-indent: 2.5em;">ให้พิจารณาผลของการประเมินความเสี่ยงโดยพิจารณาจากระดับความรุนแรงและเกณฑ์ของโอกาสที่เกิดอันตรายตามตาราง</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">โอกาสเกิดอันตราย</th>
                        <th colspan="3" class="text-center align-middle">ความรุนแรงของอันตราย</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">มาก</th>
                        <th class="text-center align-middle">ปานกลาง</th>
                        <th class="text-center align-middle">เล็กน้อย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">โอกาสมาก</td>
                        <td class="text-center">ความเสี่ยงยอมรับไม่ได้</td>
                        <td class="text-center">ความเสี่ยงสูง</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                    </tr>
                    <tr>
                        <td class="text-center">โอกาสปานกลาง</td>
                        <td class="text-center">ความเสี่ยงสูง</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                        <td class="text-center">ความเสี่ยงยอมรับได้</td>
                    </tr>
                    <tr>
                        <td class="text-center">โอกาสน้อย</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                        <td class="text-center">ความเสี่ยงยอมรับได้</td>
                        <td class="text-center">ความเสี่ยงเล็กน้อย</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <p class="text-center">----------------------------------------------------------------------------------------------------------------------------</p>
    <div class="container-sm">
        <h3>Quality</h3>
        <h4>ความรุนแรง(Severity)</h4>
        <p style="text-indent: 2.5em;">ให้ระบุว่าระดับของความรุนแรงที่เกิดอันตรายอยู่ในระดับใดลงในแบบฟอร์มการประเมินความเสี่ยงตามที่กาหนดไว้เป็น 3 ระดับ ลงในแบบฟอร์ม การประเมินความเสี่ยง</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center align-middle">รุนแรงมาก</th>
                        <th colspan="3" class="text-center align-middle">รุนแรงปานกลาง</th>
                        <th colspan="3" class="text-center align-middle">รุนแรงน้อย</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">Duration</th>
                        <th class="text-center align-middle">Duration (Critical Path)</th>
                        <th class="text-center align-middle">Cost</th>
                        <th class="text-center align-middle">Duration</th>
                        <th class="text-center align-middle">Duration (Critical Path)</th>
                        <th class="text-center align-middle">Cost</th>
                        <th class="text-center align-middle">Duration</th>
                        <th class="text-center align-middle">Duration (Critical Path)</th>
                        <th class="text-center align-middle">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ทำให้งานล่าช้าเกิน 12 ชั่วโมง</td>
                        <td>ทำให้งานล่าช้าเกิน 6 ชั่วโมง</td>
                        <td>ต้นทุนเพิ่มขึ้นเกิน 250,000 บาท</td>
                        <td>ทำให้งานล่าช้าเกิน 6 ชั่วโมง แต่ไม่เกิน 12 ชั่วโมง</td>
                        <td>ทำให้งานล่าช้าเกิน 3 ชั่วโมง แต่ไม่เกิน 6 ชั่วโมง</td>
                        <td>ต้นทุนเพิ่มขึ้นเกิน 25,000 บาทแต่ไม่เกิน 250,000 บาท</td>
                        <td>ทำให้งานล่าช้าไม่เกิน 6 ชั่วโมง</td>
                        <td>ทำให้งานล่าช้าไม่เกิน 3 ชั่วโมง</td>
                        <td>ต้นทุนเพิ่มขึ้นไม่เกิน 25,000 บาท</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h4>โอกาสที่เกิด (Likelihood)</h4>
        <p style="text-indent: 2.5em;">โอกาสที่เกิดอันตรายให้พิจารณาตามตาราง ลงในแบบฟอร์ม การประเมินความเสี่ยง</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">หัวข้อในการพิจารณา</th>
                        <th colspan="3" class="text-center align-middle">คะแนน</th>
                        <th rowspan="2" class="text-center align-middle">หมายเหตุ</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">1</th>
                        <th class="text-center align-middle">2</th>
                        <th class="text-center align-middle">3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. จำนวนคนที่ปฏิบัติงาน</td>
                        <td>จำนวนคนที่ใช้ไม่เกิน 3 คน</td>
                        <td>จำนวนคนที่ใช้ 4 - 6 คน</td>
                        <td>จำนวนคนที่ใช้มากกว่า 6 คน</td>
                        <td>ให้พิจารณาตามลักษณะงานว่าใช้จำนวนคนในการปฏิบัติเท่าไร</td>
                    </tr>
                    <tr>
                        <td>2. ความรู้ที่ใช้ในการปฏิบัติงาน</td>
                        <td>ไม่จำเป็นที่จะต้องใช้ความรู้ในงานที่ปฏิบัติ</td>
                        <td>จำเป็นที่จะต้องใช้ความรู้ และผู้ปฏิบัติงานผ่านการอบรม</td>
                        <td>จำเป็นที่จะต้องใช้ความรู้ แต่ผู้ปฏิบัติงานไม่เคยผ่านการอบรม</td>
                        <td>ให้พิจารณาความรู้ที่จำเป็นในการปฏิบัติงาน และการผ่านการอบรม</td>
                    </tr>
                    <tr>
                        <td>3. ทักษะที่ใช้ในการปฏิบัติงาน</td>
                        <td>ไม่จำเป็นที่จะต้องใช้ทักษะในงานที่ปฏิบัติ</td>
                        <td>จำเป็นที่จะต้องใช้ทักษะ และผู้ปฏิบัติงานมีทักษะ</td>
                        <td>จำเป็นที่จะต้องใช้ทักษะ แต่ผู้ปฏิบัติงานไม่มีทักษะ</td>
                        <td>ให้พิจารณาทักษะที่จำเป็นในการปฏิบัติงาน และทักษะของผู้ปฏิบัติงานที่มี</td>
                    </tr>
                    <tr>
                        <td>4. ประสบการณ์การปฏิบัติงาน</td>
                        <td>มีประสบการณ์ในการทำงานนี้มาก่อน</td>
                        <td>ไม่มีประสบการณ์ในการทำงานนี้มาก่อน แต่มีประสบการณ์ในงานที่คล้ายกัน</td>
                        <td>ไม่มีประสบการณ์ในงานนี้ หรืองานที่คล้ายกันมาก่อน</td>
                        <td>ให้พิจารณาถึงประสบการณ์ในการทำงานนี้ หรือคล้ายกัน</td>
                    </tr>
                    <tr>
                        <td>5. เครื่องมือทั่วไป</td>
                        <td>ไม่มีการใช้เครื่องมือทั่วไป</td>
                        <td>มีการใช้เครื่องมือทั่วไป และผ่านการตรวจสอบแล้ว</td>
                        <td>มีการใช้เครื่องมือทั่วไป แต่ไม่มีการตรวจสอบก่อน</td>
                        <td>ให้พิจารณาความครบถ้วน สมบูรณ์ของเครื่องมือก่อนการออกปฏิบัติงาน</td>
                    </tr>
                    <tr>
                        <td>6. เครื่องมือพิเศษ</td>
                        <td>ไม่มีการใช้เครื่องมือพิเศษ</td>
                        <td>มีการใช้เครื่องมือพิเศษ และผ่านการตรวจสอบแล้ว</td>
                        <td>มีการใช้เครื่องมือพิเศษ แต่ไม่มีการตรวจสอบก่อน</td>
                        <td>ให้พิจารณาความครบถ้วน สมบูรณ์ของเครื่องมือก่อนการออกปฏิบัติงาน</td>
                    </tr>
                    <tr>
                        <td>7. วัสดุสิ้นเปลืองที่จำเป็น</td>
                        <td>ไม่มีการใช้วัสดุสิ้นเปลือง</td>
                        <td>มีการใช้วัสดุสิ้นเปลือง และผ่านการตรวจสอบแล้ว</td>
                        <td>มีการใช้วัสดุสิ้นเปลือง แต่ไม่มีการตรวจสอบก่อน</td>
                        <td>ให้พิจารณาความครบถ้วน สมบูรณ์ของวัสดุสิ้นเปลืองที่จำเป็นก่อนการออกปฏิบัติงาน</td>
                    </tr>
                    <tr>
                        <td>8. อะไหล่/Spare Part</td>
                        <td>ไม่มีการใช้อะไหล่</td>
                        <td>มีการใช้อะไหล่ และตรวจสอบแล้ว</td>
                        <td>มีการใช้อะไหล่ แต่ยังไม่ได้มีการตรวจสอบ</td>
                        <td>พิจารณาความถูกต้องสมบูรณ์ของอะไหล่</td>
                    </tr>
                    <tr>
                        <td>9. Work Procedure/Work Instruction</td>
                        <td>มี และปรับปรุงให้ทันสมัยอยู่เสมอ</td>
                        <td>มี แต่ไม่เคยปรับปรุง หรือ จัดทำครั้งแรก</td>
                        <td>ไม่มี</td>
                        <td>จะต้องเป็นเอกสาร</td>
                    </tr>
                </tbody>
            </table>
            <p style="text-indent: 2.5em;">ให้รวมคะแนนของโอกาสเกิดอันตรายทั้งหมด(จากข้อ 1-9) แล้วคูณด้วย 100 และหารด้วย 27 โดยคำนวณเป็นเปอร์เซ็นต์เพื่อระบุเป็นค่าโอกาสเกิดตามเกณฑ์ที่กาหนดไว้</p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm display">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">ระดับโอกาสเกิด</th>
                            <th class="text-center align-middle">คะแนน</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">โอกาสเกิดน้อย</td>
                            <td class="text-center">33.33-55.55%</td>
                        </tr>
                        <tr>
                            <td class="text-center">โอกาสเกิดปานกลาง</td>
                            <td class="text-center">มากกว่า 55.55-77.77%</td>
                        </tr>
                        <tr>
                            <td class="text-center">โอกาสเกิดมาก</td>
                            <td class="text-center">มากกว่า 77.77 %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <h4>การสรุปความเสี่ยง/การตัดสินความเสี่ยง(Determine Risk)</h4>
        <p style="text-indent: 2.5em;">ให้พิจารณาผลของการประเมินความเสี่ยงโดยพิจารณาจากระดับความรุนแรงและเกณฑ์ของโอกาสที่เกิดตามตาราง</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm display">
                <thead>
                    <tr>
                        <th rowspan="2" class="text-center align-middle">โอกาสเกิด</th>
                        <th colspan="3" class="text-center align-middle">ความรุนแรง</th>
                    </tr>
                    <tr>
                        <th class="text-center align-middle">มาก</th>
                        <th class="text-center align-middle">ปานกลาง</th>
                        <th class="text-center align-middle">เล็กน้อย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">โอกาสมาก</td>
                        <td class="text-center">ความเสี่ยงยอมรับไม่ได้</td>
                        <td class="text-center">ความเสี่ยงสูง</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                    </tr>
                    <tr>
                        <td class="text-center">โอกาสปานกลาง</td>
                        <td class="text-center">ความเสี่ยงสูง</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                        <td class="text-center">ความเสี่ยงยอมรับได้</td>
                    </tr>
                    <tr>
                        <td class="text-center">โอกาสน้อย</td>
                        <td class="text-center">ความเสี่ยงปานกลาง</td>
                        <td class="text-center">ความเสี่ยงยอมรับได้</td>
                        <td class="text-center">ความเสี่ยงเล็กน้อย</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
