//var $;
layui.config({
    base: '/layuiadmin/', //静态资源所在路径
    version: true			//true 代表不缓存js
}).extend({
    index: 'lib/index' //主入口模块
}).use(['element'], function () {
    //$ = layui.jquery;         //jquery 全局
});
