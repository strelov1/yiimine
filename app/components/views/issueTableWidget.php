<table class="table table-bordered">
    <tr>
        <th><i class="icon-plus-sign"></i> Открытые</th>
        <th><i class="icon-question-sign"></i> В работе</th>
        <th><i class="icon-remove-sign"></i> Закрытые</th>
    </tr>
    <?php for ($i=0; $i<5; $i++): ?>
        <?php if (isset($open[$i]) || isset($inWork[$i]) || isset($closed[$i])): ?>
            <tr>
                <td>
                    <?php
                    if (!empty($open[$i])) {
                        if ($open[$i]['tracker_id'] == Issue::TRACKER_BUG) {
                            $tracker = ' <span class="label label-important">bug</span>';
                        } else {
                            $tracker = ' <span class="label label-info">feature</span>';
                        }

                        echo l($open[$i]['subject'], array('issue/view', 'id' => $open[$i]['id'])) . $tracker;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($inWork[$i])) {
                        if ($inWork[$i]['tracker_id'] == Issue::TRACKER_BUG) {
                            $tracker = ' <span class="label label-important">bug</span>';
                        } else {
                            $tracker = ' <span class="label label-info">feature</span>';
                        }

                        echo l($inWork[$i]['subject'], array('issue/view', 'id' => $inWork[$i]['id'])) . $tracker;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (!empty($closed[$i])) {
                        if ($closed[$i]['tracker_id'] == Issue::TRACKER_BUG) {
                            $tracker = ' <span class="label label-important">bug</span>';
                        } else {
                            $tracker = ' <span class="label label-info">feature</span>';
                        }

                        echo l($closed[$i]['subject'], array('issue/view', 'id' => $closed[$i]['id'])) . $tracker;
                    }
                    ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endfor; ?>
</table>

<style type="text/css">
    td, th {width: 300px;}
</style>