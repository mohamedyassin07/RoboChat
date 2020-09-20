<form action='#' method='post' enctype="multipart/form-data" >
        <h2><?= __('Bulk Add Clients',slug); ?></h2>
        
        </br> </br>

        <tr>
            <th scope="row">
                <label for="blogname"><?= __('Select the list',slug); ?></label>
            </th>
            <td>
                <select name="list">
                    <?php 
                        echo"<option value=''>".__('No Spicific List',slug)."</option>" ; 
                        $lists = get_terms([
                            'taxonomy' => 'list',
                            'hide_empty' => false,
                        ]);
                        foreach ((array)$lists as $list) {
                            echo"<option value='".$list->slug."'>".$list->name . "</option>" ; 
                        }
                    ?>
                </select>
            </td>
        </tr>

        </br> </br>



        
        <tr>
            <th scope="row">
                <label for="blogname">Upload CSV file</label>
            </th>
            <td>
            <input type='file' name='clients_csv' required >
            </br>
            1- Only csv files accepted 
            </br>
            2- To make it's safe : please don't upload more than 500 contact per time
            </td>
        </tr>





        <?php submit_button('upload cvs');?>
    </form>