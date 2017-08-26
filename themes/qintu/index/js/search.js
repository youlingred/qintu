(function() {
    /**
     * 从 data参数中过滤数据
     */
    var dataList = {value: []};
    dataList.value.push([11111]);
    $("#test_data").bsSuggest({
        //indexId: 2,  //data.value 的第几个数据，作为input输入框的内容
        //indexKey: 1, //data.value 的第几个数据，作为input输入框的内容
        data: dataList
    }).on('onDataRequestSuccess', function (e, result) {
        console.log('从 json.data 参数中获取，不会触发 onDataRequestSuccess 事件', result);
    }).on('onSetSelectValue', function (e, keyword, data) {
        console.log('onSetSelectValue: ', keyword, data);
    }).on('onUnsetSelectValue', function () {
        console.log("onUnsetSelectValue");
    });
}());
