/**
 * Created by Amadeus on 2017/10/15.
 */
/*系统-栏目-添加*/
function system_add(title,url,w,h){
    layer_show(title,url,w,h);
}
/*系统-栏目-编辑*/
function system_edit(title,url,id,w,h){
    layer_show(title,url,w,h);
}
/*系统-栏目-删除*/
function system_del(url){
    layer.confirm('确认要删除吗？',function(index){
        window.location.href = url;
        /*
        $.ajax({
            type: 'POST',
            url: '',
            dataType: 'json',
            success: function(data){
                $(obj).parents("tr").remove();
                layer.msg('已删除!',{icon:1,time:1000});
            },
            error:function(data) {
                console.log(data.msg);
            },
        });
        */
    });
}
/**排序ajax**/
$('.listorder input').blur(function(){
    //编写抛送的逻辑
    //获取主键的id
    var id = $(this).attr('attr-id');
    //获取排序的值
    var listorder = $(this).val();
    var postData ={
        'id' : id,
        'listorder' : listorder
    };
    var url = SCOPE.listorder_url;

    //抛送http
    $.post(url, postData, function(result) {
       //逻辑
       if(result.code == 1){
           location.href = result.data;
       }else{
           alert(result.msg);
       }
    },"json");
});

/**
 * 城市相关二级内容
 */
$('.cityId').change(function () {
    city_id = $(this).val();
    //抛送请求
    url = SCOPE.city_url;
    postData = {'id' : city_id};
    $.post(url,postData,function (result) {
        //相关业务处理
        if (result.status == 1){
            data = result.data;
            city_html = "";
            $(data).each(function (i) {
                city_html += "<option value ='"+this.id+"'>"+this.name+"</option>";
            });
            $('.se_city_id').html(city_html);
        }else if(result.status == 0){
            $('.se_city_id').html('');
        }

    },'json');
});

/**
 * 分类相关二级内容
 */
$('.categoryId').change(function () {
    category_id = $(this).val();
    //抛送请求
    url = SCOPE.category_url;
    postData = {'id' : category_id};
    $.post(url,postData,function (result) {
        //相关业务处理
        if (result.status == 1){
            data = result.data;
            category_html = "";
            $(data).each(function (i) {
                category_html += '<input name="se_category_id[]" type="checkbox" id="checkbox-moban" value="'+this.id+'"/>'+this.name;
                category_html += '<label for="checkbox-moban">&nbsp;</label>';
            });
            $('.se_category_id').html(category_html);
        }else if(result.status == 0){
            $('.se_category_id').html('');
        }

    },'json');
});
/**
 * 日期插件My97 DatePicker
 * @param flag
 */
function selecttime(flag){
    if(flag==1){
        var endTime = $("#countTimeend").val();
        if(endTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',maxDate:endTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }else{
        var startTime = $("#countTimestart").val();
        if(startTime != ""){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm',minDate:startTime})}else{
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})}
    }
}