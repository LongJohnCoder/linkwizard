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
        {{--<a href="#">Delete</a>--}}
    </td>
</tr>