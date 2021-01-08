<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            
            <table class="layui-table" id="data_list" lay-filter="data_list">
                <thead>
                <tr>
                    
                    <th>房间ID</th>
                    <th>红包ID</th>
                    <th>红包金额</th>
                    <th>被包用户</th>
                    <th>抢包时间</th>
                    <th>抢包ip</th>
                    <th>是否中雷</th>
                    <th>是否最佳</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row):?>
                <tr>
                    <td align="center"><?=$row['room_id']?></td>
                    <td><?=$row['hbao_id']?></td>
                    <td align="center"><?=sprintf("%.2f",$row['amount'] / 100)?></td>
                    <td align="center"><?=$row['user_name']?></td>
                    <td align="center"><?=$row['draw_date']?></td>
                    <td align="center"><?=$row['ip']?></td>
                    <td align="center"><?=$row['is_mine_title']?></td>
                    <td align="center"><?=$row['is_good']?></td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
