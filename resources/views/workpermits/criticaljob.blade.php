@if ($data->HotWork == 1 )
    งานที่คาดว่าอาจทำให้เกิดความร้อนหรือมีประกายไฟ 
@endif
@if ($data->ConfinedSpace == 1 )
    งานในสถานที่อับอากาศ 
@endif
@if ($data->Chemical == 1 )
    งานเกี่ยวกับสารเคมีอันตราย 
@endif
@if ($data->Lifting == 1 )
    งานยกของด้วยอุปกรณ์ยกของหนัก 
@endif
@if ($data->Scaffloding == 1 )
    งานในสถานที่สูง(นั่งร้าน) 
@endif
@if ($data->Electrical == 1 )
    งานเกี่ยวกับไฟฟ้า 
@endif
@if ($data->HighVoltage == 1 )
    งานเกี่ยวกับอุปกรณ์ไฟฟ้าแรงสูง 
@endif
@if ($data->Drilling == 1 )
    งานเกี่ยวกับงานขุดเจาะ 
@endif
@if ($data->Radio == 1 )
    งานเกี่ยวกับกัมมันตภาพรังสี 
@endif
@if ($data->Diving == 1 )
    งานประดาน้ำ 
@endif
{{ $data->Other }}