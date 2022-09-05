<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataRequestsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_requests')->delete();
        
        \DB::table('data_requests')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'data request123',
                'tenant_id' => 21,
                'description' => NULL,
                'file_name' => 'assets/uploads/data_file/sample_chemical.csv',
                'data_request' => '"[{\\"Chemical name\\":\\"Test csv\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Commercial\\",\\"Brand name\\":\\"Simreka\\",\\"IUPAC\\":\\"actinium\\",\\"CAS\\":\\"1-0-10,2-02-0\\",\\"INCHI\\":\\"InChI=1S\\\\/Ac\\",\\"INCHI key\\":\\"QQINRWTZWGJFDB-UHFFFAOYSA-N\\",\\"EC number\\":\\"1232\\",\\"Molecular formula\\":\\"H20\\",\\"SMILES\\":\\"CCOO2CC==O2C,CCOOOC\\",\\"SMILES type\\":\\"canonical,Isotopes\\",\\"Other names\\":\\"Tst\\",\\"Tags\\":\\"test,csv,data\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"Test\\"}]"',
                'status' => 'Draft',
                'requested_by' => 0,
                'requested_by_tenant' => 0,
                'requested_date' => NULL,
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-14 23:25:01',
                'created_at' => '2022-04-14 23:22:42',
                'updated_at' => '2022-04-14 23:25:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'test',
                'tenant_id' => 21,
                'description' => NULL,
                'file_name' => 'assets/uploads/data_file/Chemical CSV.csv',
            'data_request' => '"[{\\"Chemical Name\\":\\"Ammonia\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"Simreka\\",\\"IUPAC\\":\\"Trial\\",\\"CAS\\":\\"1-0-10,2-02-0\\",\\"INCHI\\":\\"InChI=1S\\\\/Ac\\",\\"INCHI key\\":\\"QQINRWTZWGJFDB-UHFFFAOYSA-N\\",\\"EC number\\":\\"1232\\",\\"Molecular formula\\":\\"NH3\\",\\"SMILES\\":\\"CCOO2CC==O2C,CCOOOC\\",\\"SMILES type\\":\\"canonical,Isotopes\\",\\"Other names\\":\\"Tst\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"No\\",\\"Note\\":\\"Test\\"},{\\"Chemical Name\\":\\"carbon\\",\\"Categories\\":\\"Simreka\\",\\"Classification\\":\\"Simulated (Mixed Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"demo product\\",\\"Categories\\":\\"Simreka\\",\\"Classification\\":\\"Commercial (Mixed Chemical)\\",\\"Brand Name\\":\\"product\\",\\"IUPAC\\":\\"wewewr\\",\\"CAS\\":\\"asas,ewre,tytyu,uioiuo\\",\\"INCHI\\":\\"123123ewre\\",\\"INCHI key\\":\\"ewrwerew\\",\\"EC number\\":\\"werewrewr\\",\\"Molecular formula\\":\\"34343411\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"canonical\\",\\"Other names\\":\\"778,yuiuyi,uyiui\\",\\"Tags\\":\\"wer,rtrt,tyty\\",\\"Own Product\\":\\"Yes\\",\\"Note\\":\\"ret\\"},{\\"Chemical Name\\":\\"methone\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"ch3\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"pxylene\\",\\"Categories\\":\\"Simreka\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"Test\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"test\\",\\"IUPAC\\":\\"test\\",\\"CAS\\":\\"test\\",\\"INCHI\\":\\"test\\",\\"INCHI key\\":\\"test\\",\\"EC number\\":\\"test\\",\\"Molecular formula\\":\\"test\\",\\"SMILES\\":\\"test\\",\\"SMILES type\\":\\"test\\",\\"Other names\\":\\"test\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"No\\",\\"Note\\":\\"test\\"},{\\"Chemical Name\\":\\"Test csv\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"Simreka\\",\\"IUPAC\\":\\"actinium\\",\\"CAS\\":\\"1-0-10,2-02-0\\",\\"INCHI\\":\\"InChI=1S\\\\/Ac\\",\\"INCHI key\\":\\"QQINRWTZWGJFDB-UHFFFAOYSA-N\\",\\"EC number\\":\\"1232\\",\\"Molecular formula\\":\\"H20\\",\\"SMILES\\":\\"CCOO2CC==O2C,CCOOOC\\",\\"SMILES type\\":\\"canonical,Isotopes\\",\\"Other names\\":\\"Tst\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"No\\",\\"Note\\":\\"Test\\"},{\\"Chemical Name\\":\\"Test csv\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"Simreka\\",\\"IUPAC\\":\\"actinium\\",\\"CAS\\":\\"1-0-10,2-02-0\\",\\"INCHI\\":\\"InChI=1S\\\\/Ac\\",\\"INCHI key\\":\\"QQINRWTZWGJFDB-UHFFFAOYSA-N\\",\\"EC number\\":\\"1232\\",\\"Molecular formula\\":\\"H20\\",\\"SMILES\\":\\"CCOO2CC==O2C,CCOOOC\\",\\"SMILES type\\":\\"canonical,Isotopes\\",\\"Other names\\":\\"Tst\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"No\\",\\"Note\\":\\"Test\\"},{\\"Chemical Name\\":\\"test demo\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"testchemical\\",\\"Categories\\":\\"Simreka\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"122\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"Water\\",\\"Categories\\":\\"Company\\",\\"Classification\\":\\"Other\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"\\",\\"CAS\\":\\"\\",\\"INCHI\\":\\"\\",\\"INCHI key\\":\\"\\",\\"EC number\\":\\"\\",\\"Molecular formula\\":\\"H2O\\",\\"SMILES\\":\\"\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"\\",\\"Note\\":\\"\\"},{\\"Chemical Name\\":\\"sample product\\",\\"Categories\\":\\"simreka\\",\\"Classification\\":\\"Compound (Pure Chemical)\\",\\"Brand Name\\":\\"\\",\\"IUPAC\\":\\"123\\",\\"CAS\\":\\"123\\",\\"INCHI\\":\\"123123ewre\\",\\"INCHI key\\":\\"123\\",\\"EC number\\":\\"123\\",\\"Molecular formula\\":\\"O2\\",\\"SMILES\\":\\"123\\",\\"SMILES type\\":\\"isotopes\\",\\"Other names\\":\\"123\\",\\"Tags\\":\\"\\",\\"Own Product\\":\\"Yes\\",\\"Note\\":\\"test\\"}]"',
                'status' => 'Draft',
                'requested_by' => 0,
                'requested_by_tenant' => 0,
                'requested_date' => NULL,
                'created_by' => 28,
                'updated_by' => 28,
                'deleted_at' => '2022-04-15 16:58:51',
                'created_at' => '2022-04-15 16:58:40',
                'updated_at' => '2022-04-15 16:58:51',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'ds1',
                'tenant_id' => 21,
                'description' => NULL,
                'file_name' => 'assets/uploads/data_file/dataset1.csv',
                'data_request' => '"[{\\"fvgf\\":\\"ffjj\\"}]"',
                'status' => 'Draft',
                'requested_by' => 0,
                'requested_by_tenant' => 0,
                'requested_date' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 14:48:42',
                'updated_at' => '2022-04-27 14:48:42',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'ds2',
                'tenant_id' => 21,
                'description' => NULL,
                'file_name' => 'assets/uploads/data_file/dataset1.csv',
                'data_request' => '"[{\\"fvgf\\":\\"ffjj\\"}]"',
                'status' => 'Draft',
                'requested_by' => 0,
                'requested_by_tenant' => 0,
                'requested_date' => NULL,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2022-04-27 14:49:54',
                'updated_at' => '2022-04-27 14:49:54',
            ),
        ));
        
        
    }
}