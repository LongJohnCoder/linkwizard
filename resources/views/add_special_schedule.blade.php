@php
    if (isset($_GET['tab_count']))
    {
        $tr_index = $_GET['tab_count'];
    }
@endphp


<tr id="special_url-<?=$tr_index?>">
    <td>
        <input type="date" name="special_date[]" class="form-control">
    </td>
    <td>
        <input type="text" name="special_date_redirect_url[]" class="form-control" placeholder="Enter your url here">
    </td>
    <td>
        <span data-count="<?=$tr_index?>" id="add_button_<?=$tr_index?>">
            <a class="btn btn-primary" onclick="addMoreSpecialLink(), dispButton(<?=$tr_index?>)"><i class="fa fa-plus"></i></a>
        </span>
        <span data-count="<?=$tr_index?>" id="delete_button_<?=$tr_index?>" style="display: none;">
            <a class="btn btn-primary" onclick="delTabRow(<?=$tr_index?>)"><i class="fa fa-minus"></i></a>
        </span>
    </td>
</tr>