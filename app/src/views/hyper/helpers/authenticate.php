<script>
    async function authenticate() {

        const sdk = new Appwrite();

        sdk.setEndpoint('<?= $this->e($endpoint) ?>') // Your API Endpoint
            .setProject('<?= $this->e($project) ?>'); // Your project ID

        let session = sdk.account.createSession('iurygdeoliveira@hotmail.com', '.appwrite@12')

        let result = await session.then(function(response) {

            return response;

        }).catch(function(error) {
            console.log(error); // Error
            return false;
        });

        if (result === false) {
            return false;
        }

        let jwt = sdk.account.createJWT();

        result = await jwt.then(function(response) {

            return response;

        }).catch(function(error) {
            console.log(error); // Error
            return false;
        });

        if (result === false) {
            return false;
        } else {
            return result.jwt;
        }

    }
</script>