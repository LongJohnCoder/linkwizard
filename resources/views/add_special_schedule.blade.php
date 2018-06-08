@php
    if (isset($_GET['tab_count']))
    {
        $tr_index = $_GET['tab_count'];
    }
@endphp


<tr id="special_url-<?php echo $tr_index?>">
    <td>
        <input type="input" id="schedule_datepicker_<?php echo $tr_index?>" class="schedule_datepicker" name="special_date[]" class="form-control">
        <input type="hidden" id="scd_id_<?php echo $tr_index?>" name="special_date[<?php echo $tr_index?>]">
    </td>
    <td>
        <input type="text" id="special_url_<?php echo $tr_index?>" name="special_date_redirect_url[]" class="form-control" placeholder="Enter your url here" onchange="checkUrl(this.value)">
    </td>
    <td>
        <!--<span data-count="<?php echo $tr_index?>" id="add_button_<?php echo $tr_index?>">
            <a class="btn btn-primary" onclick="addMoreSpecialLink(), dispButton(<?php echo $tr_index?>)"><i class="fa fa-plus"></i></a>
        </span>-->
        <span data-count="<?php echo $tr_index?>" id="delete_button_<?php echo $tr_index?>" style="display: block;">
            <a class="btn btn-primary" onclick="delTabRow(<?php echo $tr_index?>)"><i class="fa fa-minus"></i></a>
        </span>
    </td>
</tr>