<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            
            <table class="layui-table" id="data_list" lay-filter="data_list">
                <thead>
                <tr>
                    <th>等级</th>
                    <th>消费金额</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row):?>
                <tr>
                    <td align="center"><?=$row['id']?></td>
                    <td><?=sprintf("%.2f",$row['score'] / 100)?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

